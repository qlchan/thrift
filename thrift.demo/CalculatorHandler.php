<?php
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TPhpStream;
use Thrift\Transport\TBufferedTransport;

class CalculatorHandler  implements  \tutorial\CalculatorIf {
	
  protected $log = array();

  public function ping() {
    error_log("ping()");
  }

  public function add($num1, $num2) {
    error_log("add({$num1}, {$num2})");
    return $num1 + $num2;
  }

  public function calculate($logid, \tutorial\Work $w) {
    error_log("calculate({$logid}, {{$w->op}, {$w->num1}, {$w->num2}})");
    switch ($w->op) {
      case \tutorial\Operation::ADD:
        $val = $w->num1 + $w->num2;
        break;
      case \tutorial\Operation::SUBTRACT:
        $val = $w->num1 - $w->num2;
        break;
      case \tutorial\Operation::MULTIPLY:
        $val = $w->num1 * $w->num2;
        break;
      case \tutorial\Operation::DIVIDE:
        if ($w->num2 == 0) {
          $io = new \tutorial\InvalidOperation();
          $io->what = $w->op;
          $io->why = "Cannot divide by 0";
          throw $io;
        }
        $val = $w->num1 / $w->num2;
        break;
      default:
        $io = new \tutorial\InvalidOperation();
        $io->what = $w->op;
        $io->why = "Invalid Operation";
        throw $io;
    }

    $log = new \shared\SharedStruct();
    $log->key = $logid;
    $log->value = (string)$val;
    $this->log[$logid] = $log;

    return $val;
  }

  public function getStruct($key) {
    error_log("getStruct({$key})");
    // This actually doesn't work because the PHP interpreter is
    // restarted for every request.
    //return $this->log[$key];
    return new \shared\SharedStruct(array("key" => $key, "value" => "PHP is stateless!"));
  }
  public function zip() {
    error_log("zip()");
  }
}



?>