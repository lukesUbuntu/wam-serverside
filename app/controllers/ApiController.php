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
     * Retrieves events from cache or fetches and returns events
     */
    public function getEventsAction()
    {
        if (!$this->request->isGet())
            $this->response("incorrect request type",false);

        //get longiture if not null
        $longitude = $this->request->get("longitude",null,false);
        $latitude = $this->request->get("latitude",null,false);

        if (!$longitude)
            $this->response("missing longitude ",false);

        if (!$latitude)
            $this->response("missing latitude",false);

        //check memcache
        $response = $this->fromCache('getEvents');

        if (!$response){

            $url = "http://api.eventfinda.co.nz/v2/events.json?point=$latitude,$longitude&radius=5";
            //Set username and password for api access
            $username = "wip";
            $password = "y6w26w93mfbr";
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($process);
            $this->setCache('getEvents',$response);
        }

            $this->response($response);


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