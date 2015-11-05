<?php

namespace AppBundle\Utility\Design;
use AppBundle\Utility\Design\DesignMode;

class ObserverTest extends DesignMode {
  function runTest() {
    $login = new Login();
    $obs01 = new SecurityMonitor($login);
    $obs02 = new GeneralLogger($login);
    $obs03 = new PartnershipTool($login);
    $login->handleLogin();
  }
}   

class Login implements SplSubject {
  private $storage;
  private $status = false;

  function handleLogin() {
    switch ( rand(1, 3) ) {
      case 1:
        $ret = $this->status = true; break;
      case 2:
        $ret = $this->status  = false; break;
      case 3:
        $ret = $this->status  = false; break;
    }
    $this->notify();  
    return $ret;
  }

  function getStatus() {
    return $this->status;
  }

  function __construct() {
    $this->storage = new SqlObjectStorage();    
  }

  function attach(SplObserver $observer) {
    $this->storage->attach($observer);
  }

  function detach(SplObserver $observer) {
    $this->storage->detach($observer);
  }

  function notify() {
    foreach ($this->storage as $obs) {
      $obs->update($this);
    }
  }
}

abstract class LoginObserver implements SplObserver {
  private $login;
  function __construct(Login $login) {
    $this->login = $login;
    $login->attach($this);
  }

  function update(SplSubject $subject) {
    if($subject === $this->login) {
      $this->doUpdate($subject);
    }
  }

  abstract function doUpdate(Login $login);
}

class SecurityMonitor extends LoginObserver {
  function doUpdate(Login $login) {
    $status = $login->getStatus();

    if($status) {
      print __CLASS__ . ": \tsending mail to Admin\n";
    }
  }
}

class GeneralLogger extends LoginObserver {
  function doUpdate(Login $login) {
    $status = $login->getStatus();

    if($status) {
      print __CLASS__ . ": \tadd login data to log\n";
    }
  }
}

class PartnershipTool extends LoginObserver {
  function doUpdate(Login $login) {
    $status = $login->getStatus();

    if(!$status) {
      print __CLASS__ . ": \tset cookie if IP matches a list\n";
    }
  }
}