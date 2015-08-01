<?php

/**
 * Created by PhpStorm.
 * User: Luke Hardiman
 * Date: 1/08/2015
 * Time: 3:30 PM
 * @description api controller to handle request to mobiel wam client
 */
use Phalcon\Mvc\Model\Criteria;

class ApiController extends ControllerBase
{
    /**
     * Index action main call to /api
     */
    public function IndexAction()
    {
        $this->response("Invalid API call", false);
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