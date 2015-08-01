<?php
//putting debug info here for now
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

use Phalcon\Mvc\Controller;


class ControllerBase extends Controller
{
    private $cache = null;      //memcache


    public function initialize()
    {
        // Cache data for 5 mins
        $frontCache = new \Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 300
        ));
        //Create the Cache setting memcached connection options
        $this->cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
            'host' => 'localhost',
            'port' => 11211,
            'persistent' => false
        ));
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
}
