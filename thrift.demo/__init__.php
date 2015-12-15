<?php
require_once __DIR__.'/Thrift/ClassLoader/ThriftClassLoader.php';
use Thrift\ClassLoader\ThriftClassLoader;
$GEN_DIR = dirname(__FILE__).'/gen-php/';
$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', __DIR__ );
$loader->registerDefinition('shared', $GEN_DIR);
$loader->registerDefinition('tutorial', $GEN_DIR);
$loader->register();