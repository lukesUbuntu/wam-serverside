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

    public function fromCache($event,$longitude,$latitude){
        return $this->cache->get($event);
    }
    public function setCache($event,$data,$longitude,$latitude){
        $this->cache->save($event, $data);
    }
}
