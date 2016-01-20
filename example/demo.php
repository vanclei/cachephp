<?php

include __DIR__ . '/../vendor/autoload.php';

use CachePHP\CacheService;

/*
 * Setting a cache value
 */
$cache_service = new CacheService();
$cache_service->write('KEY_1', 'Hello World Today');
$cache_service->write('KEY_2', 'Hello World Tomorrow');

/*
 * Getting that cache value
 */
echo $cache_service->get('KEY_1') . PHP_EOL;

/*
 * Getting that cache key from memory
 */
echo $cache_service->get('KEY_1', 'memory') . PHP_EOL;

/*
 * Getting that cache key from memcache
 */
echo $cache_service->get('KEY_2', 'memcache') . PHP_EOL;

/* 
 * Remove KEY_1 
 */
$cache_service->delete('KEY_1');


/* 
 * Remove everything 
 */
$cache_service->flush();