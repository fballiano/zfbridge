ZFBridge
========

Bridge class to replicate the ease of Zend_Db in Zend Framework 2.

### LICENSE

The files in this archive are released under the New BSD license.
You can find a copy of this license in LICENSE.txt.

### USAGE

```php
require_once "ZFBridge/Db.php";

// first of all we need the zf2 autoloader
$autoloader = new Zend\Loader\StandardAutoloader(array('autoregister_zf' => true));
$autoloader->register();

// instancing db adapter
$adapter = new Zend\Db\Adapter\Adapter(array(
	'driver'       =>'Pdo_Mysql',
	'hostname'     => DB_READ_HOST,
	'username'     => DB_READ_USER,
	'password'     => DB_READ_PASS,
	'database'     => DB_READ_NAME,
	'characterset' => 'UTF8'
));

// replacing adapter with ZFBridge
$adapter = new \ZFBridge\Db($adapter);

// now we can use the old style fetchPairs etc
$adapter->fetchPairs("SELECT id, name FROM sampletable");
```