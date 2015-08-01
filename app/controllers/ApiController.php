<?php

/**
 * Created by PhpStorm.
 * User: Luke Hardiman
 * Date: 1/08/2015
 * Time: 3:30 PM
 * @description api controller to handle request to mobiel wam client
 */
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Http\Client\Provider;

class ApiController extends ControllerBase
{
    //@todo add memcache/or caching for json calls back to client

    /**
     * Index action main call to /api
     */
    public function IndexAction()
    {

        $this->response("Invalid API call", false);
    }

    /**
     *
     */
    public function getNewsAction(){
        if (!$this->request->isGet())
            $this->response("incorrect request type",false);

        //get longitude if not null
        $longitude = $this->request->get("longitude",null,false);
        $latitude = $this->request->get("latitude",null,false);

        if (!$longitude)
            $this->response("missing longitude ",false);

        if (!$latitude)
            $this->response("missing latitude",false);
        //check memcache
        $response = $this->fromCache('getNews',$longitude,$latitude);
        if (!$response){
            //update out memcache
            $url = "http://wellington.gen.nz/geotagged/json";

            $process = curl_init($url);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($process);
            $this->setCache('getNews',$longitude,$latitude,$response);

        }



        $this->response($response);
    }
    /**
     * Retrieves events from cache or fetches and returns events
     */
    public function getEventsAction()
    {
        if (!$this->request->isGet())
            $this->response("incorrect request type",false);

        //get longitude if not null
        $longitude = $this->request->get("longitude",null,false);
        $latitude = $this->request->get("latitude",null,false);

        if (!$longitude)
            $this->response("missing longitude ",false);

        if (!$latitude)
            $this->response("missing latitude",false);

        //check memcache
        $response = $this->fromCache('getEvents',$longitude,$latitude);

        if (!$response){
            $url = "http://api.eventfinda.co.nz/v2/events.json?point=$latitude,$longitude&radius=10";
           //Set username and password for api access

            $username = "wip";
            $password = "y6w26w93mfbr";
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($process);
            //add in distance

            $this->setCache('getEvents',$longitude,$latitude,$response);

        }


        $this->response($response);


    }
    private function distanceEvent($response){
        $data = json_decode($response);
        $events = array();
        foreach($data->events as $event){

            if (isset($event->point->lat) && ($event->point->lng)){
                $distance = $this->calcDistance($event->point->lat,$event->point->lng,$latitude,$longitude);
                $event->distance = $distance;
            }

            $events[] = $event;
        }
    }
    private function distanceNews($response){
        $news_items = json_decode($response);
        $news_results = array();

        foreach($news_items as $news){
            if (isset($news->place->latLong->latitude) && (isset($news->place->latLong->longitude))){
                $distance = $this->calcDistance($news->place->latLong->latitude,$news->place->latLong->longitude,$latitude,$longitude);
                $news->distance = $distance;
            }
            $news_results[] = $news;

        }
    }
    /**
     * @description returns the distance in km between latitude points
     * @param $latitude1
     * @param $longitude1
     * @param $latitude2
     * @param $longitude2
     * @return float km
     */
    private function calcDistance($latitude1, $longitude1, $latitude2, $longitude2) {
        //source found https://www.marketingtechblog.com/calculate-distance/
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        //kms
        $distance = $distance * 1.609344;
        return (round($distance,2));
    }
    /**
     * @param $data response to send back as JSON with Callback
     * @param bool|true $success
     * @param int $status_code of response default 200
     * @param string $status_message of response default OK
     */
    private function response($data, $success = true, $status_code = 200, $status_message = "OK")
    {
        //disable view
        $this->view->disable();
        //new response
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode($status_code, $status_message);
        $response->setContentType('application/json', 'utf-8');
        //encode call
        $json = json_encode(array('success' => $success, 'data' => $data));
        //set response to send back check for callback
        $response->setContent(isset($_GET['callback'])
            ? "{$_GET['callback']}($json)"
            : $json);
        $response->send();
        exit; //kill from other processing
    }

}