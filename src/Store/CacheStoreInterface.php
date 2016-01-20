<?php

namespace CachePHP\Store;

/**
 * Represents a cache store
 * 
 * @author Vanclei Picolli <vancleip@gmail.com>
 *
 */
interface CacheStoreInterface
{
	/**
	 * 
	 * @param string $key
	 * @return mixed
	 */
	public function get($key);
	
	/**
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @param int $minutes
	 */
	public function write($key, $value, $minutes);
	
	/**
	 * 
	 * @param string $key
	 */
	public function delete($key);
	
	/**
	 * @return string prefix for the cache provider
	 */
	public function getPrefix();
	
	/**
	 * Flushes the cache
	 */
	public function flush();
	
	/**
	 * Extend the existing expiry on the key
	 * 
	 * @param string $key
	 * @param int $minutes
	 */
	public function extend($key, $minutes);
	
	/**
	 * Increment the key
	 * @param string $key
	 */
	public function increment($key);
	
	/**
	 * Decrement the key
	 * 
	 * @param string $key
	 */
	public function decrement($key);
}