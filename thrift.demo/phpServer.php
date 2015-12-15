<?php
require_once __DIR__.'/__init__.php';
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TPhpStream;
use Thrift\Transport\TBufferedTransport;
require_once  __DIR__.'/CalculatorHandler.php';

header('Content-Type', 'application/x-thrift');
if (php_sapi_name() == 'cli') {
  echo "\r\n";
}

$handler = new CalculatorHandler();
$processor = new \tutorial\CalculatorProcessor($handler);

$transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
$protocol = new TBinaryProtocol($transport, true, true);

$transport->open();

$processor->process($protocol, $protocol);
echo 22;exit;
$transport->close();
