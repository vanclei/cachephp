<?php

namespace CachePHP\Tests;

use CachePHP\CacheService;


/**
 * Tests for Cache Service.
 */
class CacheServiceTest extends \PHPUnit_Framework_TestCase
{


    private $cacheService;

    public function setUp() {
        /*
         * Setting a cache value
         */
        $this->cache_service = new CacheService();
    }


    public function getCacheList()
    {
        return array(
            array(
                array('KEY_1' => 'Hello World Today', 
                      'KEY_2' => 'Hello World Tomorrow')
            )
        );
    }

    /**
     * @dataProvider getCacheList
     */
    public function testMemcache($collection)
    {


        foreach ($collection as $key => $content) {
  
            $this->cache_service->write($key, $content);
            /*
             * Getting that cache value
             */

            $this->assertEquals($this->cache_service->get($key), $content);

            /*
             * Getting that cache key from memory
             */

            $this->assertEquals($this->cache_service->get($key,  'memory'), $content);
            /*
             * Getting that cache key from memcache
             */

            $this->assertEquals($this->cache_service->get($key,  'memcache'), $content);

            /* 
             * Remove KEY_1 then KEY_2
             */
            $this->cache_service->delete($key);

            /*
             * Check if the cache value is still alive
             */

            $this->assertNotEquals($this->cache_service->get($key), $content);

            /*
             * Check if the cache key is in memory
             */

            $this->assertNotEquals($this->cache_service->get($key,  'memory'), $content);
            /*
             * Check if the cache key is in memcache
             */

            $this->assertNotEquals($this->cache_service->get($key,  'memcache'), $content);

            /* 
             * Remove everything 
             */
            $this->cache_service->flush();

        }
    }
}
