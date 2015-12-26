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

  public static function parseJsonString( $tResult )
  {
    $result = WebJson::stringToJson($tResult);

    if ( !isset($result->{'result'}) ) return $tResult;

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
      $categoryName = trim( $value->{'categoryName'} );
      // $categoryName = utf8_encode($value->{'categoryName'});
      $children = $value->{'children'}->{'list'};

      $ret = $ret . "{ \"id\": $id, \"categoryName\": \"$categoryName\", \"children\": [";

      foreach ($children as $item) {
        $id = $item->{'id'};
        $categoryName = trim( $item->{'categoryName'} );
        // $categoryName = utf8_encode($item->{'categoryName'});
        // $children = $item->{'children'}->{'list'};         
        $ret = $ret . "{ \"id\": $id, \"categoryName\": \"$categoryName\", \"children\": [] }, ";
      }

      $ret = rtrim(trim($ret), ',') . ']},';
    }
    $ret = rtrim(trim($ret), ',') . ']}';

    return $ret;
  }

  public static function parseCoursesJsonString( $result, $courseRepo )
  {
    $result = WebJson::stringToJson($result);

    $result = $result->{'result'}->{'list'};
    $ret = '{ "result": [';

    foreach ($result as $value) {
      $id = $value->{'id'};
      $title = $value->{'title'};
      $price = $value->{'price'};
      $description = strip_tags ( $value->{'description'} );
      $contentCount = $value->{'contentCnt'};
      $coursePhoto = strip_tags (  $value->{'coursePhoto'} );

      $course = $courseRepo->findOneBy( array('ablesky_id' => $id) );
      $course_teacher = 'empty';
      if( $course ) $course_teacher = $course->getTeacher()->getName();
      // $ret = $ret . "{ \"id\": $id, \"title\": \"$title\", \"price\": \"$price\", \"description\": \"$description\", \"contentCount\": \"$contentCount\", \"coursePhoto\": \"$coursePhoto\" }, ";
      $ret = $ret . "{ \"id\": $id, \"title\": \"$title\", \"price\": \"$price\", \"contentCount\": \"$contentCount\", \"coursePhoto\": \"$coursePhoto\", \"teacher\": \"$course_teacher\" }, ";
    }

    $ret = rtrim(trim($ret), ',') . ']}';
    return $ret;
  }

  public static function strRemoveSpace_old( $str )  
  {
  //   $matches = explode('<br>',$str);
  //   var_dump($matches);

  //   foreach ($matches as $line) {
      
  //   }

    $str = preg_replace('/\s(?=\s)/', '', $str); 
    $str = preg_replace('/[\n\r\t]/', '', $str);
    $str = str_replace('&nbsp;', '', $str);



    return $str;
  }

  public static function strRemoveSpace02( $str )
  {
    $str = trim($str); //清除字符串两边的空格
    $str = strip_tags($str,""); //利用php自带的函数清除html格式
    $str = preg_replace("/\t/","",$str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
    $str = preg_replace("/\r\n/","",$str); 
    $str = preg_replace("/\r/","",$str); 
    $str = preg_replace("/\n/","",$str); 
    $str = preg_replace("/ /","",$str);
    $str = preg_replace("/  /","",$str);  //匹配html中的空格
    return trim($str); //返回字符串
  }

  public static function strRemoveSpace( $str )
  {
    $str = trim($str); //清除字符串两边的空格
    $str = strip_tags($str,""); //利用php自带的函数清除html格式
    $str = preg_replace("/\t/","",$str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
    $str = preg_replace("/\r\n/","",$str); 
    $str = preg_replace("/\r/","",$str); 
    $str = preg_replace("/\n/","",$str); 
    $str = preg_replace("/ /","",$str);
    $str = preg_replace("/  /","",$str);  //匹配html中的空格
    $str = str_replace('&nbsp;', '', $str);
    return trim($str); //返回字符串
  }
}