<?php

namespace AppBundle\Utility\WebTest;

// use Symfony\Component\Config\Definition\Exception\Exception;
// use Symfony\Component\HttpFoundation\Response;
// use AppBundle\Utility\RunTestMode;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class WebCalculator
{
  // private static serializer;

  // public function __construct( Serializer $serializer )
  // {
  //   $this->serializer = $serializer;
  // }

  public static function getSerializerObject( )
  {
    $encoders = array(new XmlEncoder(), new JsonEncoder());
    $normalizers = array(new ObjectNormalizer());
    $serializer = new Serializer($normalizers, $encoders);
    return $serializer;
  }

  public static function add ( $val01, $val02 ) 
  {
    return $val01 + $val02;
  }

  public static function stringToJson( $str )
  {
    // $serializer = WebCalculator::getSerializerObject();
    // return $serializer->serialize($str, 'json');
    return json_decode($str);
  }

  public static function valueToJson( $json )
  {
    return json_encode($str, JSON_PRETTY_PRINT);
  }
}