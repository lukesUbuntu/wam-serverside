<?php
//putting debug info here for now
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

use Phalcon\Mvc\Controller;


class ControllerBase extends Controller
{
    private $cache = null;      //memcache
    public $cords = null;

    public function initialize()
    {
        // Cache data for 5 mins
        $frontCache = new \Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 0
        ));
        //Create the Cache setting memcached connection options
        $this->cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
            'host' => 'localhost',
            'port' => 11211,
            'persistent' => false
        ));

        $this->cords = $this->_getCords();
    }

    /**
     * @param $event
     * @param longitude
     * @param latitude
     * @return data or false
     */
    public function fromCache($event,$longitude,$latitude){
        $cacheKey = $this->cacheKey($event,$longitude,$latitude);

        return $this->cache->get($cacheKey);
    }

    /**
     * @param $event
     * @param $data to be stored
     * @param $longitude
     * @param $latitude
     */
    public function setCache($event,$longitude,$latitude,$data){
        $cacheKey = $this->cacheKey($event,$longitude,$latitude);

        $this->cache->save($cacheKey, $data);
    }

    /**
     * @param $latLong  longitude or latitude
     * @return int
     */
    private function _cacheKey($latLong){
        $re = "/(\\d+)./";
        if (preg_match($re, $latLong, $matches))
           return $matches[0];
    }

    /**
     * @param $event
     * @param $longitude
     * @param $latitude
     * @return string formated key
     */
    private function cacheKey($event,$longitude,$latitude){
        //returns format eg : getEvents.174.41.
        return $event.'.'.$this->_cacheKey($longitude).$this->_cacheKey($latitude);
    }

    /**
     * @return stdClass cords longitude & latitude from get request
     */
    private function _getCords(){
        //get longitude if not null
        $longitude = $this->request->get("longitude",null,false);
        $latitude = $this->request->get("latitude",null,false);

        if (!$longitude)
            $this->response("missing longitude ",false);

        if (!$latitude)
            $this->response("missing latitude",false);

        $cords = new stdClass();
        $cords->longitude = $longitude;
        $cords->latitude = $latitude;
        return $cords;
    }

    /**
     * @param $data response to send back as JSON with Callback
     * @param bool|true $success
     * @param int $status_code of response default 200
     * @param string $status_message of response default OK
     */
    public function response($data, $success = true, $status_code = 200, $status_message = "OK")
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
