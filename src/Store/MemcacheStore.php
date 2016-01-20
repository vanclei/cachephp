<?php

namespace CachePHP\Store;

use CachePHP\Wrapper\MemcacheWrapper;

/**
 * Represents a Memcache store
 *
 * @author Vanclei Picolli <vancleip@gmail.com>
 *
 */
class MemcacheStore implements CacheStoreInterface
{
	private $memcache;
	
	public function __construct(MemcacheWrapper $memcache_wrapper)
	{
		$this->memcache = $memcache_wrapper->getMemcache();
	}
	
	public function get($key){
		return $this->memcache->get($this->getPrefix() . ':' . $key);
	}
	
	public function write($key, $value, $minutes)
	{
		$flags = 0;
		 
		if (is_string($value) == true || is_array($value) == true || is_object($value) == true) {
			$flags = MEMCACHE_COMPRESSED;
		}
		
		$this->memcache->set($this->getPrefix() . ':' . $key, $value, $flags, $minutes*60);
	}
	
	public function delete($key)
	{
		$this->memcache->delete($this->getPrefix() . ':' . $key);
	}
	
	public function increment($key)
	{
		$this->memcache->increment($this->getPrefix() . ':' . $key);
	}
	
	public function decrement($key)
	{
		$this->memcache->increment($this->getPrefix() . ':' . $key);
	}
	
	public function extend($key, $minutes)
	{
		$value = $this->get($key);
		
		if (false === $value) {
			return;
		}
		
		$this->delete($key);
		
		$this->write($key, $value, $minutes*60);
	}
	
	public function getPrefix()
	{
		return 'memcache';
	}
	
	public function flush()
	{
		$this->memcache->flush();
	}
}