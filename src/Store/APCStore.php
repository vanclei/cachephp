<?php 

namespace CachePHP\Store;

/**
 * APC Cache Store
 *
 * @author Vanclei Picolli <vancleip@gmail.com>
 *
 */
class APCStore implements CacheStoreInterface {

	/**
	 * Indicates if APCu is supported.
	 */
	protected $apcu = false;

	public function __construct()
	{
		$this->apcu = function_exists('apcu_fetch');
	}

	public function get($key)
	{
		return $this->apcu ? apcu_fetch($key) : apc_fetch($key);
	}

	public function write($key, $value, $minutes)
	{
		return $this->apcu ? apcu_store($key, $value, $minutes*60) : apc_store($key, $value, $minutes*60);
	}

	public function delete($key)
	{
		return $this->apcu ? apcu_delete($key) : apc_delete($key);
	}

	public function flush()
	{
		$this->apcu ? apcu_clear_cache() : apc_clear_cache('user');
	}

	public function increment($key)
	{
		return $this->apcu ? apcu_inc($key) : apc_inc($key);
	}
	
	public function decrement($key)
	{
		return $this->apcu ? apcu_dec($key) : apc_dec($key);
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
		return 'apc';
	}
}