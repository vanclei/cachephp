<?php

namespace CachePHP;

use CachePHP\Store\ArrayStore;
use CachePHP\Store\APCStore;
use CachePHP\Store\MemcacheStore;
use CachePHP\Store\CacheStoreInterface ;
use CachePHP\Wrapper\MemcacheWrapper;
use CachePHP\Wrapper\APCWrapper;

/**
 * Cache Service, boostraps the different cache stores and fetches, adds and deletes.
 *
 * @author Vanclei Picolli <vancleip@gmail.com>
 *
 */
class CacheService implements CacheStoreInterface
{
	private $cache_stores = array();
	
	/**
	 * Adds a cache store to the cache registry
	 * 
	 * @param IStoreInterface $store
	 */
	public function registerCacheStore(CacheStoreInterface $store)
	{
		$this->cache_stores[$store->getPrefix()] = $store;
	}
	
	/**
	 * Get all cache stores
	 * @return mixed
	 */
	public function getCacheStores()
	{
		return $this->cache_stores;
	}
	
	/**
	 * Get a cache store by its prefix
	 * 
	 * @param string $prefix
	 * @return mixed:
	 */
	public function getCacheStoreByPrefix($prefix)
	{	
		if (false === array_key_exists($prefix, $this->cache_stores)) {
			return false;
		}
		
		return $this->cache_stores[$prefix];
	}

	/**
	 * 
	 * Fetch stored data from the first cache store which has it
	 * Can also fetch from a particular store by passing a prefix
	 * 
	 * @param string $key
	 * @param string $prefix
	 * @return mixed
	 */
	public function get($key, $prefix = false)
	{
		if (false !== $prefix) {
			return $this->getCacheStoreByPrefix($prefix)->get($key);
		}
		
		foreach ($this->getCacheStores() AS $store) {
			
			$cache = $store->get($key);
			
			if (false === $cache) {
				continue;
			}
			
			return $cache;
		}
		
		return false;
	}
	
	/**
	 * Write key/value pair to all cache stores
	 * 
	 * @param string $key
	 * @param string $value
	 * @param int $minutes
	 * @param string $prefix
	 */
	public function write($key, $value, $minutes = 0, $prefix = false)
	{
		if (false !== $prefix) {
			return $this->getCacheStoreByPrefix($prefix)->write($key, $value, $minutes);
		}
		
		foreach ($this->getCacheStores() AS $store) {
			$store->write($key, $value, $minutes);
		}
	}
	
	/**
	 * Deletes a cache by key
	 * 
	 * @param string $key
	 * @param string $prefix
	 */
	public function delete($key, $prefix = false)
	{
		if (false !== $prefix) {
			return $this->getCacheStoreByPrefix($prefix)->delete($key);
		}
		
		foreach ($this->getCacheStores() AS $store) {
			$store->delete($key);
		}
	}
	
	/**
	 * Flush all cache stores
	 * 
	 * @param string $prefix
	 */
	public function flush($prefix = false)
	{
		if (false !== $prefix) {
			return $this->getCacheStoreByPrefix($prefix)->flush();
		}
		
		foreach ($this->getCacheStores() AS $store) {
			$store->flush();
		}
	}

	/**
	 * Increment the cache by key
	 *
	 * @param string $prefix
	 */
	public function increment($key, $prefix = false)
	{
		if (false !== $prefix) {
			return $this->getCacheStoreByPrefix($prefix)->increment($key);
		}
	
		foreach ($this->getCacheStores() AS $store) {
			$store->increment($key);
		}
	}	
	
	/**
	 * Decrement the cache by key
	 *
	 * @param string $prefix
	 */
	public function decrement($key, $prefix = false)
	{
		if (false !== $prefix) {
			return $this->getCacheStoreByPrefix($prefix)->decrement($key);
		}
	
		foreach ($this->getCacheStores() AS $store) {
			$store->decrement($key);
		}
	}
	
	/**
	 * Extend the life of the cache key
	 *
	 * @param string $prefix
	 */
	public function extend($key, $minutes, $prefix = false)
	{
		if (false !== $prefix) {
			return $this->getCacheStoreByPrefix($prefix)->extend($key, $minutes);
		}
	
		foreach ($this->getCacheStores() AS $store) {
			$store->extend($key, $minutes);
		}
	}
	
	public function __construct()
	{
		$this->registerCacheStore(new ArrayStore());
		$this->registerCacheStore(new ApcStore());
		$this->registerCacheStore(new MemcacheStore(new MemcacheWrapper()));
	}
	
	public function getPrefix()
	{
	}
}
