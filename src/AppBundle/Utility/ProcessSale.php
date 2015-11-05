<?php

// src/AppBundle/Utility/ProcessSale.php
namespace AppBundle\Utility;

class ProcessSale 
{
  private $callbacks;

  public function __constrcut()
  {
    $this->callbacks = array();
  }

  public function registerCallback( $callback ) 
  {
    if ( !is_callable( $callback )) {
      throw new Exception("callback not callable", 1);      
    }
    $this->callbacks[] = $callback;
  }

  public function sale( $product ) 
  {
    // ret = "";
    $ret = "1234: {$product->getName()}: ";
    foreach ($this->callbacks as $callback) {
      $ret += call_user_func( $callback, $product );
    }
    return $ret;
  }

  public function details( $product ) 
  {
    return "ProcessSale: {$product->getName()}";
  }
}
