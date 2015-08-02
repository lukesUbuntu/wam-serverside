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
     * api/getRoadWorks
     * @description returns news articles that are geo located
     */
    public function getRoadWorksAction(){

        //get long & lat
        //$cords = $this->cords;

        $response = $this->fromCache('getRoadWorks', $this->cords->longitude, $this->cords->latitude);
        if (!$response){
            $url =('http://www.nzta.govt.nz/assets/tas/markercollection.json');
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($process);

            $response = $this->setDistanceRoadWorks($response);
            $this->setCache('getRoadWorks',$this->cords->longitude,$this->cords->latitude,$response);

        }




        $this->response($response);
        /*
        foreach ($road_events->roadworks->features as $newevents) {


        }*/
    }
    /**
     * api/getNews
     * @description returns news articles that are geo located
     */
    public function getNewsAction(){
        if (!$this->request->isGet())
            $this->response("incorrect request type",false);

        //get long & lat
        $cords = $this->cords;

        //check memcache
        $response = $this->fromCache('getNews', $cords->longitude, $cords->latitude);
        if (!$response){
            //update out memcache
            $url = "http://wellington.gen.nz/geotagged/json";

            $process = curl_init($url);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($process);
            //add in distance
            $response = $this->setDistanceNews($response);
            $this->setCache('getNews',$cords->longitude,$cords->latitude,$response);


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

        //get long & lat
        $cords = $this->cords;

        //check memcache
        $response = $this->fromCache('getEvents', $cords->longitude, $cords->latitude);

        if (!$response){
            $url = "http://api.eventfinda.co.nz/v2/events.json?point=$cords->latitude,$cords->longitude&radius=10";
           //Set username and password for api access

            $username = "wip";
            $password = "y6w26w93mfbr";
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($process);
            //add in distance
            $response = $this->setDistanceEvent($response);

            $this->setCache('getEvents',$cords->longitude,$cords->latitude,$response);

        }


        $this->response($response);


    }



    /** placeholder for distance for roadworks */
    private function setDistanceRoadWorks($response){
        $data = json_decode($response);
        $cords = $this->cords;

        $road_works = array();
        $roadworks_data = $data->roadworks->features;

        foreach($roadworks_data as $issue){

            // $issue->images->{'images'}[0]->transforms->transforms[0]->url
            if (count($issue->geometry->coordinates) > 1){
                $distance = $this->calcDistance($issue->geometry->coordinates[1],$issue->geometry->coordinates[0],$cords->latitude, $cords->longitude);

                $issue->distance = $distance;

                if ($distance < 50)
                $road_works[] = $issue;
            }

        }

        return $road_works;
    }
    /** placeholder for distance for events */
    private function setDistanceEvent($response){
        $data = json_decode($response);
        $cords = $this->cords;

        $events = array();
        foreach($data->events as $event){

            if (isset($event->point->lat) && ($event->point->lng)){
                $distance = $this->calcDistance($event->point->lat,$event->point->lng,$cords->latitude, $cords->longitude);
                $event->distance = $distance;

                if (isset($event->images->{'images'})){
                    $event->thumbnail = $event->images->{'images'}[0]->transforms->transforms[0]->url;
                }

            }

            $events[] = $event;
        }
        return $events;
    }
    /** placeholder for distance for news */
    private function setDistanceNews($response){
        $news_items = json_decode($response);
        $news_results = array();
        $cords = $this->cords;

        foreach($news_items as $news){
            if (isset($news->place->latLong->latitude) && (isset($news->place->latLong->longitude))){
                $distance = $this->calcDistance($news->place->latLong->latitude,$news->place->latLong->longitude,$cords->latitude, $cords->longitude);
                $news->distance = $distance;

                if (empty($news->imageUrl))
                    $news->imageUrl = "http://wam.nzhost.me/img/default.jpg";


            /*if (empty($news->imageUrl))
                $news->imageUrl = "http://wam.nzhost.me/img/default.jpg";
                //http://wam.nzhost.me/img/default.jpg*/
            }
            $news_results[] = $news;

        }

        return $news_results;
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


}