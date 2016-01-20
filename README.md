CachePHP
==============================

Multi layer CachePHP Service provider.

Requirements
============

* Memcache
* APC

Installation
============

The recommended installation method is through [Composer](http://getcomposer.org).

Add ``vanclei/CachePHP`` as a dependency in your project's ``composer.json`` file:

```bash
{
    "require": {
        "vanclei/CachePHP": "*"
    }
}
```

You can find out more on how to install Composer, configure autoloading, and other best-practices for defining dependencies at [getcomposer.org](http://getcomposer.org).

### Running test suite

```bash
$ ./vendor/bin/phpunit src/Tests/

Example usage
--------------------
```php
// include the composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use CachePHP\CacheService;

//Write to cache for 30 mins with the key DEMO and value Hello World
$cache = new CacheService();
$cache->write('DEMO', 'Hello World', 30);

//Available for the next 30 mins
$cache->get('DEMO');

$cache->delete('DEMO');
```
    
For another example please take a look at the examples folder.
    
    
    
