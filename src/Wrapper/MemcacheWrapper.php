<?php

namespace CachePHP\Wrapper;

use Memcache;
use Symfony\Component\Yaml\Parser;

/**
 * Wrapper class to wrap memcache connections
 *
 * @author Vanclei Picolli <vancleip@gmail.com>
 *
 */
class MemcacheWrapper
{
	private $memcache;
	
	/**
	* Start Memcache Service according with the memcache.yml settings
	*/
	public function __construct()
	{
		$memcache = new Memcache;

		$yaml = new Parser();
			
		$servers = $yaml->parse(
			file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'memcache.yml')
		);
		
		foreach ($servers AS $server) 
		{
			$memcache->addServer(
				$server['host'], $server['port'], $server['weight']
			);
		}
		
		if (false === $memcache->getVersion()) {
			throw new RuntimeException("Could not establish Memcache connection.");
		}
		
		$this->memcache = $memcache;
	}
	
	public function getMemcache()
	{
		return $this->memcache;
	}
}