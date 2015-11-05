<?php

namespace AppBundle\Utility\WebUtility;

class WebAuto
{
  const ABLE_SKY_KEY = "E1F244781A9F4F42BD7E6ADB2316B0FF";
  const ABLE_SKY_URL = "http://www.ablesky.com/organizationCategory.do?action=listOrgInteriorCategoryTree";
  const ABLE_SKY_COURSES_URL = "http://mobile.ablesky.com/organization.do?action=getCourseForCategory";#&orgId=8778&src=wap&categoryId=207470";
  const ORG_ID = "8778";
  // const DEBUG = TRUE;
  const DEBUG = FALSE;

  public static function pEcho($name, $string)
  {
    if ( WebAuto::DEBUG )echo "$name: $string</br>";
  }

  public static function makeUp()
  {
    $body = '
      <p>I like pickles and herring.</p>
      <a href="pickle.php"><img src="pickle.jpg"/>A pickle picture</a>
      I have a herringbone-patterned toaster cozy.
      <herring>Herring is not a real HTML element!</herring>
    ';

    $words = array('pickle', 'herring');
    $replacements = array();
    foreach ($words as $i => $word) {
      $replacements[] = "<span class='word-$i'>$word</span>";
    }

    $parts = preg_split("{(<(?:\"[^\"]*\"|'[^'}*'|[^'\">])*>)}",
                        $body,
                        -1,
                        PREG_SPLIT_DELIM_CAPTURE);
    foreach ($parts as $i => $part) {
      if (isset($part[0]) && ($part[0] == '<')) { continue; }
      $parts[$i] = str_replace( $words, $replacements, $part );
    }

    $body = implode('', $parts);

    return $body;
  }

  public static function makePregSplit()
  {
    $result = preg_split("/[\s,]+/", "hypertext language, programming");
    return $result;
  }

  public static function webURL()
  {
    return WebAuto::ABLE_SKY_URL;
  }

  public static function webBuildURL()
  {
    return WebAuto::webURL() . '&' . WebAuto::webBuildParams();
  }

  public static function webBuildParams()
  {
    return http_build_query( WebAuto::webBuildParamsArray() );
  }

  public static function webBuildParamsArray()
  {
    $orgParams = array();
    $orgParams['organizationId'] = "8778" ;
    // $orgParams['optDate'] = WebAuto::getMillisecond();
    $orgParams['optDate'] = time() * 1000;
    // print_r(getdate());
    // $orgParams['optDate'] = microtime(true);
    // $orgParams['optDate'] = "1446196830000";
    $access_key = WebAuto::ABLE_SKY_KEY;
    // $access_key = "E1F244781A9F4F42BD7E6ADB2316B0FF";

    $orgInfoWithKey = $orgParams['organizationId'] . "|" . $orgParams['optDate'] . "|" . $access_key;
    // echo "</br>";
    // echo $orgInfoWithKey;
    $accessToken = md5($orgInfoWithKey);
    // echo "</br>";
    // echo $accessToken;
    // echo "</br>";
    // "7abfa9530f226d55205f897dbcbcc60c"
    $orgParams['accessToken'] = $accessToken;
    return $orgParams;
  }

  public static function webBuildGetCoursesURL( $categoryId )
  {
    $url = WebAuto::ABLE_SKY_COURSES_URL . "&orgId=" . WebAuto::ORG_ID . "&src=wap&categoryId=" . $categoryId;
    return $url;
  }

  private static function getMillisecond() { 
    // list($s1, $s2) = explode(' ', microtime()); 
    // return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000); 
    $time = explode ( " ", microtime () );  
    $time = $time [1] . ($time [0] * 1000);  
    $time2 = explode ( ".", $time );  
    $time = $time2 [0];  
    return $time;
  }
}