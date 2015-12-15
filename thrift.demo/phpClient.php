<?php
namespace tutorial\php;
require_once __DIR__.'/__init__.php';

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;

try {
 // if (array_search('--http', $argv)) {
    $socket = new THttpClient('localhost', 80, '/thrift/phpServer.php');
/*  } else {
    $socket = new TSocket('127.0.0.1', 8080);
  }*/
  $transport = new TBufferedTransport($socket, 1024, 1024);
  $protocol = new TBinaryProtocol($transport);
  $client = new \tutorial\CalculatorClient($protocol);

  $transport->open();

  $client->ping();
  print "ping()\n";

  $sum = $client->add(1,1);
  print "1+1=$sum\n";

  $work = new \tutorial\Work();

  $work->op = \tutorial\Operation::DIVIDE;
  $work->num1 = 1;
  $work->num2 = 0;

  try {
    $client->calculate(1, $work);
    print "Whoa! We can divide by zero?\n";
  } catch (\tutorial\InvalidOperation $io) {
    print "InvalidOperation: $io->why\n";
  }

  $work->op = \tutorial\Operation::SUBTRACT;
  $work->num1 = 15;
  $work->num2 = 10;
  $diff = $client->calculate(1, $work);
  print "15-10=$diff\n";

  $log = $client->getStruct(1);
  print "Log: $log->value\n";

  $transport->close();

} catch (TException $tx) {
  print 'TException: '.$tx->getMessage()."\n";
}
