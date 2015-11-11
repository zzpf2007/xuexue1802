<?php

namespace AppBundle\Utility\WebApi;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Entity\Category;

class WebApiCategoryOld
{
  private $categoryItem;
  private $restClient;
  private static $instance;

  private function __construct( $category, $restClient )
  {
    $this->categoryItem = $category;
    $this->restClient = $restClient;
  }

  public static function getInstance( $category, $restClient ) {
    if( !(self::$instance instanceof self) ){
      self::$instance = new self( $category, $restClient );
    }
    return self::$instance;
  }

  public function getMobileJson()
  {
    $retJson = "";
    $categoryType = $this->getCategoryItem()->getType();

    switch ( $categoryType ) {
      case ( 'root' ) :
        $retJson = $this->getRootResponse();
        break;
      case ( 'child' ) :
        $retJson = $this->getChildResponse();
        break;
      case ( 'detail') :
        $retJson = $this->getDetailResponse();
        break;
      default : 
        $retJson = '';
    }
    // WebAuto::pEcho('getMobileJson response', $retJson);
    return $retJson;
  }

  private function getDetailResponse()
  {
    $retResponse = "";
    $category = $this->getCategoryItem();
    $categoryId = $category->getAbleskyId() ? $category->getAbleskyId() : 999990;

    $timeExpired = CheckData::dateExpired($category->getUpdated());

    if ( $timeExpired ) {
      $url = WebAuto::webBuildGetCoursesURL($categoryId);
    }
  }

  private function getChildResponse()
  {
    $retResponse = "";
    $category = $this->getCategoryItem();

    $categoryId = $category->getAbleskyId() ? $category->getAbleskyId() : 99999;   
    // $categoryId = $category->getAbleskyId();   
    $timeExpired = CheckData::dateExpired($category->getUpdated());

    if ( $timeExpired ) {
      $url = WebAuto::webBuildGetCoursesURL($categoryId);
      WebAuto::pEcho('mobile url', $url);
      $content = $this->getWebResult( $url );
      $raw_md5 = md5($content);  

      if ( $raw_md5 != $category->getMd5() ) {
        $retResponse = WebJson::parseCoursesJsonString($content);
        $this->setCategory($categoryId, 'child', $content, $retResponse, $raw_md5);
      }
      $this->getCategoryItem()->setSave();
      $this->getCategoryItem()->setUpdated( new \DateTime('now') );
    }

    $retResponse = $category->getMobileJson();
    return $retResponse;
  }

  private function getRootResponse() 
  {
    $retResponse = "";
    $category = $this->getCategoryItem();

    $timeExpired = CheckData::dateExpired($category->getUpdated());

    WebAuto::pEcho('time expired', $timeExpired);

    if ( $timeExpired ) {
      $url = WebAuto::webBuildURL();
      WebAuto::pEcho('url', $url);
      $content = $this->getWebResult( $url );
      $raw_md5 = md5($content);
      WebAuto::pEcho('raw md5', $raw_md5);
      WebAuto::pEcho('category md5', $category->getMd5());

      if ( $raw_md5 != $category->getMd5() ) {
        $retResponse = WebJson::parseJsonString($content);      
        $this->setCategory(1, 'root', $content, $retResponse, $raw_md5);
        WebAuto::pEcho('category md5', $category->getMd5());
        // WebAuto::pEcho('mobile json', $category->getMobileJson());        
      }
      $this->getCategoryItem()->setSave();
      $this->getCategoryItem()->setUpdated( new \DateTime('now') );
      WebAuto::pEcho('category save', $category->getSave());
    }

    $retResponse = $category->getMobileJson();
    // WebAuto::pEcho('mobile response', $retResponse);
    return $retResponse;
  }

  private function setCategory($categoryId, $categorytype, $rawJson, $mobJson, $md5)
  {
    $category = $this->getCategoryItem();    
    $category->setAbleskyId($categoryId);
    $category->setType($categorytype);
    $category->setRawJson($rawJson);
    $category->setMobileJson($mobJson);    
    $category->setMd5($md5);
  }

  function getResponse() {
    $url = WebAuto::webBuildURL();
    $content = $this->getWebResult( $url );
    $result = WebJson::parseJsonString($content);
    return $this->generateCategoryItem( $content, $result);
    // return $result;
  }

  public function getCoursesByCategoryId( $categoryId )
  {
    $url = WebAuto::webBuildGetCoursesURL( $categoryId );
    $content = $this->getWebResult( $url );
    $result = WebJson::parseCoursesJsonString($content);
    return $this->generateCategoryItem( $content, $result, $categoryId);
    // return $result;
  }

  private function getCategoryItem()
  {
    $retCategoryItem = $this->categoryItem;
    if ( !$retCategoryItem ) $retCategoryItem = new Category();
    return $retCategoryItem;
  }

  private function getWebResult( $url )
  {
    $restClient = $this->restClient;
    $response = $restClient->get($url);
    $content = $response->getContent();
    return $content;
  }

  private function generateCategoryItem( $rawContent, $mobileContent, $categoryId = null)
  {
    $category = new Category();
    $category->setRawJson($rawContent);
    $category->setMobileJson($mobileContent);
    if ( isset($categoryId) ){
      $category->setAbleskyId($categoryId);
      $category->setType('item');
    } else {
      $category->setAbleskyId(1);
      $category->setType('root');
    }
    $category->setMd5(md5($rawContent));
    return $category;
  }
}
