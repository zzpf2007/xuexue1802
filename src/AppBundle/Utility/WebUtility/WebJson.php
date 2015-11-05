<?php

namespace AppBundle\Utility\WebUtility;

class WebJson
{
  public static function stringToJson( $str )
  {
    $ret = json_decode($str);

    if ($ret === null && json_last_error() !== JSON_ERROR_NONE) {
      $error_message = sprintf("Failed to parse json string '%s', error: '%s'", $str , json_last_error());
      throw new \LogicException($error_message);
      $ret = '{ "result": 9, "message": ' . $error_message .'}';
    }

    return $ret;
  }

  public static function valueToJson( $json )
  {
    return json_encode($str, JSON_PRETTY_PRINT);
  }

  public static function parseJsonString( $result )
  {
    $result = WebJson::stringToJson($result);

    $result = $result->{'result'}->{'list'};
    $ret = '{ "result": [';

    foreach ($result as $value) {
      // if ( is_array($value) ) {
      //   print_r($value);
      // } else {          
      //   // print "$key: $value";
      //   print_r($value);
      // }

      $id = $value->{'id'};
      $categoryName = $value->{'categoryName'};
      // $categoryName = utf8_encode($value->{'categoryName'});
      $children = $value->{'children'}->{'list'};

      $ret = $ret . "{ \"id\": $id, \"categoryName\": \"$categoryName\", \"children\": [";

      foreach ($children as $item) {
        $id = $item->{'id'};
        $categoryName = $item->{'categoryName'};
        // $categoryName = utf8_encode($item->{'categoryName'});
        // $children = $item->{'children'}->{'list'};         
        $ret = $ret . "{ \"id\": $id, \"categoryName\": \"$categoryName\", \"children\": [] }, ";
      }

      $ret = rtrim(trim($ret), ',') . ']},';
    }
    $ret = rtrim(trim($ret), ',') . ']}';

    return $ret;
  }

  public static function parseCoursesJsonString( $result )
  {
    $result = WebJson::stringToJson($result);

    $result = $result->{'result'}->{'list'};
    $ret = '{ "result": [';

    foreach ($result as $value) {
      $id = $value->{'id'};
      $title = $value->{'title'};
      $ret = $ret . "{ \"id\": $id, \"title\": \"$title\" }, ";
    }

    $ret = rtrim(trim($ret), ',') . ']}';
    return $ret;
  }
}