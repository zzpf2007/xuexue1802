<?php

namespace AppBundle\Utility\WebApi\WebResponse;

use AppBundle\Utility\WebApi\WebResponse\WebResponseMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Entity\Category;

class CategoryRootResponse extends WebResponseMode
{
  private $category;

  public function __construct( $container ) 
  {
    parent::__construct($container);
    $this->category = $this->getCategory();
  }

  public function getResponse()
  {
    $retReult = '';    
    $timeExpired = CheckData::dateExpired( $this->category->getUpdatedAt() );

    $timeExpired = true;

    if ( isset( $this->category ) && $timeExpired ) {
      $url = $this->buildURL();
      $content = $this->getAbleSkyResponse( $url );

      $retResult = $this->buildMobileJson( $content );
      $this->category->setUpdatedAt( new \DateTime('now') );
      $this->saveToDB( $this->category );
    }
      
    $retResult = $this->getMobileJson();

    return $retResult; 
  }

  private function getMobileJson() 
  {
    return $this->category->getMobileJson();
  }

  private function buildURL()
  {
    return WebAuto::webBuildURL();
  }

  private function buildMobileJson( $content )
  {
    $retResult = '';
    $raw_md5 = md5( $content );
    $cat_md5 = $this->category->getMd5();
    if ( $cat_md5 && $this->getMobileJson() && $cat_md5 == $raw_md5 ) {
      $retResult = $this->getMobileJson();
    } else {
      $retResult = WebJson::parseJsonString($content);
      $this->setCategory( $content, $retResult, $raw_md5 );
    }

    return $retResult;
  }

  private function setCategory( $rawJson, $mobileJson, $raw_md5 )
  {
    $this->category->setRawJson($rawJson);
    $this->category->setMobileJson($mobileJson);
    $this->category->setMd5($raw_md5);
  }

  private function getCategory()
  {
    $entityRepo = $this->getDoctrine()
                       ->getRepository('AppBundle:Category');

    $item = $entityRepo->findOneBy(array('type' => 'root'), array('updatedAt' => 'DESC'));
    if ( !$item ) {
      $item = new Category();
      $item->setAbleskyId(1);
      $item->setType('root');
    }

    return $item;
  }
}
