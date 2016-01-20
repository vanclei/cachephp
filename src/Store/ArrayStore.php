<?php

namespace CachePHP\Store;

/**
 * In-memory Cache Store
 *
 * @author Vanclei Picolli <vancleip@gmail.com>
 *
 */
class ArrayStore implements CacheStoreInterface
{
	private $cache = array();
	
	public function get($key)
	{	
		if (false === array_key_exists($key, $this->cache)) {
			return false;
		}
		
		return $this->cache[$key];
	}
	
	public function write($key, $value, $minutes)
	{
		$this->cache[$key] = $value;
	}
	
	public function delete($key)
	{	
		if (false === array_key_exists($key, $this->cache)) {
			return false;
		}
		
		unset($this->cache[$key]);
	}

	public function increment($key)
	{
		return $this->cache[$key] = $this->cache[$key] + 1;
	}
	
	public function decrement($key)
	{
		return $this->cache[$key] = $this->cache[$key] - 1;
	}
	
	public function extend($key, $minutes)
	{
		return;
	}
	
	public function getPrefix()
	{
		return 'memory';
	}
	
	public function flush()
	{
		$this->cache = array();
	}
}