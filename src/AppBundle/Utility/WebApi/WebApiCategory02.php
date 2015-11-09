<?php

namespace AppBundle\Utility\WebApi;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Entity\Category;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;

class WebApiCategory02 extends WebApiMode
{
  private $category;
  private $webResponse;

  public function __construct( $container, $itemId = null ) 
  {
    parent::__construct($container);
    $this->category = $this->getCategory( $itemId );
    $this->webResponse = $this->getResponseObject();
  }

  private function getResponseObject()
  {
    $categoryType = $this->category->getType();
    $responseObj;

    switch ( $categoryType ) {
      case ( 'root' ) :
        $responseObj = new CategoryRootResponse(); break;
      case ( 'child' ) :
        $responseObj = new CategoryChildResponse(); break;
      default : 
        $responseObj = new CategoryRootResponse();
    } 

    return $responseObj;
  }

  public function getResult() 
  {
    // $retResult = $this->handleCategoryRequest();
    return $this->webResponse->getResponse();
  }

  private function handleCategoryRequest() 
  {
    $retResult = '';

    $categoryType = $this->category->getType();

    switch ( $categoryType ) {
      case ( 'root' ) :
        // $retResult = $this->getRootResponse(); break;
        $this->webResponse = new CategoryRootResponse(); break;
      case ( 'child' ) :
        $this->webResponse = new CategoryChildResponse(); break;
        // $retResult = $this->getChildResponse(); break;
      default : 
        $retResult = '';
    }

    $retResult = $this->webResponse->getResponse();

    return $retResult;
  }

  private function getRootResponse()
  {
    $retReult = '';    
    $timeExpired = CheckData::dateExpired( $this->category->getUpdatedAt() );
    // $timeExpired = true;

    if ( $this->category && $timeExpired ) {
      $url = $this->buildRootURL();
      $content = $this->getAbleSkyResponse( $url );

      $retResult = $this->buildRootMobileJson( $content );
      $this->category->setUpdatedAt( new \DateTime('now') );
      $this->saveCategory();
    }
      
    $retResult = $this->getMobileJson();

    return $retResult;
  }

  private function buildRootMobileJson( $content )
  {
    $retResult = '';
    $raw_md5 = md5( $content );
    $cat_md5 = $this->category->getMd5();
    if ( $cat_md5 && $this->getMobileJson() && $cat_md5 == $raw_md5 ) {
      $retResult = $this->getMobileJson();
    } else {
      $retResult = WebJson::parseJsonString($content);
      $this->setCategory( $content, $retResult, $raw_md5, 'root' );
    }

    return $retResult;
  }

  private function setCategory( $rawJson, $mobileJson, $raw_md5, $type )
  {
    $this->category->setRawJson($rawJson);
    $this->category->setMobileJson($mobileJson);
    $this->category->setMd5($raw_md5);
    $this->category->setType($type);
  }

  private function saveCategory()
  {
    $em = $this->getDoctrine()->getManager();
    $em->persist($this->category);
    $em->flush();
  }

  private function getMobileJson()
  {
    return $this->category->getMobileJson();
  }

  private function buildRootURL()
  {
    return WebAuto::webBuildURL();
  }

  private function getAbleSkyResponse( $url )
  {
    $restClient = $this->container->get('ci.restclient');
    $response = $restClient->get($url);
    return $response->getContent();
  }

  private function getCategory( $itemId = null )
  {
    $entityRepo = $this->getDoctrine()
                       ->getRepository('AppBundle:Category');

    $item = null;
    if ( $itemId ) {        
      $item = $entityRepo->findOneBy( array('ablesky_id' => $itemId), array('updatedAt' => 'DESC') );
      if ( !$item ) {
        $item = new Category();
        $item->setAbleskyId($itemId);
        $item->setType('child');
      }
    } else {
      $item = $entityRepo->findOneBy(array('type' => 'root'), array('updatedAt' => 'DESC'));
      if ( !$item ) {
        $item = new Category();
        $item->setAbleskyId(1);
        $item->setType('root');
      }
    }

    return $item;
  }

  public function getMobileJson02()
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

  private function getRootResponse02() 
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

  private function setCategory02($categoryId, $categorytype, $rawJson, $mobJson, $md5)
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
