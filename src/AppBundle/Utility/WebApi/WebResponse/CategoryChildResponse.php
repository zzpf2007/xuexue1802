<?php

namespace AppBundle\Utility\WebApi\WebResponse;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebApi\WebResponse\WebResponseMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Entity\Category;
use AppBundle\Entity\Course;

class CategoryChildResponse extends WebResponseMode
{
  private $category;
  private $entityManager;
  private $courseRepo;

  public function __construct( $container, $itemId ) 
  {
    parent::__construct($container);
    $this->category = $this->getCategory( $itemId );
    $this->courseRepo = $container->get('doctrine')->getManager()->getRepository('AppBundle:Course');
  }

  public function getResponse()
  {
    $retReult = '';    
    $timeExpired = CheckData::dateExpired( $this->category->getUpdatedAt() );

    $timeExpired = true;
    
    if ( isset( $this->category ) && $timeExpired ) {
    // if ( $timeExpired ) {
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
    return WebAuto::webBuildGetCoursesURL( $this->category->getAbleskyId() );
  }

  private function buildMobileJson( $content )
  {
    $retResult = '';
    $raw_md5 = md5( $content );
    $cat_md5 = $this->category->getMd5();
    // if ( $cat_md5 && $this->getMobileJson() && $cat_md5 == $raw_md5 ) {
    if ( false ) {
      $retResult = $this->getMobileJson();
    } else {
      $retResult = WebJson::parseCoursesJsonString($content, $this->courseRepo);
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

  private function getCategory( $itemId )
  {
    $entityRepo = $this->getDoctrine()
                       ->getRepository('AppBundle:Category');

    $item = $entityRepo->findOneBy( array('ablesky_id' => $itemId), array('updatedAt' => 'DESC') );
    if ( !$item ) {
      $item = new Category();
      $item->setAbleskyId($itemId);
      $item->setType('child');
    }

    return $item;
  }
}
