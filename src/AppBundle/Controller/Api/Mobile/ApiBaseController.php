<?php

namespace AppBundle\Controller\Api\Mobile;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiFactory;
use AppBundle\Utility\WebApi\WebApiCategory;
use AppBundle\Utility\Check\CheckString;
use AppBundle\Entity\Category;
use AppBundle\Entity\Course;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Controller\Utility\WebUtility;

class ApiBaseController extends Controller
{
    public function userAction(Request $request)
    {
      // replace this example code with whatever you need
      $courseRepo = $this->getDoctrine()
                         ->getRepository('AppBundle:User');

      $users = $courseRepo->findAll();

      $result = "";
      foreach ( $users as $user ) {
        $result = $result . $user->getEmail();
      }

      // $data = $request->get('data');
      // $timestamp = $request->get('timestamp');
      // $accessToken = $request->get('accessToken');
      // // $data = $request->request->get('data');
      
      // $logger = $this->get('my_service.logger');
      // $logger->debug(date('Y-m-d H:i:s'));

      // // return new Response("{ data: ". $data ." }");
      // $logger->debug($request);
      // $result = sprintf('{ "data": "%s", "timestamp":"%s", "accessToken": "%s"}', $data , $timestamp, $accessToken);
      // // $result = sprintf("{ 'data': '%s', 'timestamp':'%s', 'accessToken': '%s'}", $data , $timestamp, $accessToken);
      return new Response($result);
    }

    public function categoryActoin(Request $request, $id)
    {
      $result = $this->handleCategoryResponse( $id );
      return new Response(CheckString::check( $result ));
    }

    public function courseAction(Request $request, $id)
    {
      // $result = $this->handleCourseResponse( $id );
      $webApiCourse = WebApiFactory::getInstance('course', $this->container, $id );
      $result = $webApiCourse->getResult();
      return new Response(CheckString::check( $result ));
    }

    public function handleCategoryResponse( $categoryId = null )
    {
      $category = $this->findCategory( $categoryId );
      WebAuto::pEcho('original save', $category->getSave());      
      // var_dump($category->getUpdated());
      $restClient = $this->container->get('ci.restclient');
      $webApi = WebApiCategory::getInstance($category, $restClient);
      $resultMobileJson = $webApi->getMobileJson();
      // WebAuto::pEcho('result json', $resultMobileJson);
      // if ( $category->getSave() ) $this->saveCategory($category);
      if ( $category->getSave() ) $this->saveCategory($category);
      // var_dump($category);
      // WebAuto::pEcho('result save', $category->getSave());
      return $resultMobileJson;
    }

    private function buildCategoryResponse( $categoryId = null )
    {
      $category = $this->findCategory( $categoryId );      
      var_dump($category->getUpdated());

      if (   !isset($category) || 
           ( isset($category) && CheckData::dateExpired($category->getUpdated()->getTimestamp()) ) 
         )
      {
        $restClient = $this->container->get('ci.restclient');
        $webApi = WebApiFactory::getInstance('categories', $restClient);

        $original_md5 = "";
        if ( isset($category) ) $original_md5 = $category->getMd5();

        // $category;
        // echo $categoryId;

        if( $categoryId != 1 ) {
          $category = $webApi->getCoursesByCategoryId($categoryId);
        } else {
          $category = $webApi->getResult();
        }

        $new_md5 = $category->getMd5();
        if ( $original_md5 != $new_md5 ) $this->saveCategory($category);
      }    

      return $category;
    }

    private function saveCategory( $category )
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();
    }

    private function findCategory( $categoryId = null )
    {
      $categoryRepo = $this->getDoctrine()
                           ->getRepository('AppBundle:Category');
      $category = null;
      if( $categoryId != 1 ){
        $category = $categoryRepo->findOneBy(array('ablesky_id' => $categoryId), array('updated' => 'DESC'));
        if ( !$category ) {
          $category = new Category();
          $category->setAbleskyId($categoryId);
          $category->setType('child');
        }
      } else {
        $category = $categoryRepo->findOneBy(array('type' => 'root'), array('updated' => 'DESC'));
        if ( !$category ) {
          $category = new Category();
          $category->setAbleskyId(1);
          $category->setType('root');
        }
      }

      return $category;
    }

    public function findCourse( $course_id = null )
    {
      $courseRepo = $this->getDoctrine()
                         ->getRepository('AppBundle:Course');
      $course = null;
      if ( $course_id ) {        
        $course = $courseRepo->findOneBy( array('ablesky_id' => $course_id), array('updatedAt' => 'DESC') );
        if ( !$course ) {
          $course = new Course();
          $course->setAbleskyId($course_id);
        }
      }

      return $course;
    }

    public function handleCourseResponse( $course_id = null )
    {
      $course = $this->findCourse( $course_id );
      $restClient = $this->container->get('ci.restclient');

      $retResult = '{ "result" : [';

      if ( $course ) {
        $url = 'http://www.ablesky.com/kecheng/detail_' . $course->getAbleskyId();

        $response = $restClient->get($url);
        $content = $response->getContent();
        $opts = array('output-xhtml' => true,
                      'numeric-entities' => true);
        $xml = tidy_repair_string($content, $opts, 'utf8');
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('xhtml','http://www.w3.org/1999/xhtml');
        $titles = $xpath->query('//xhtml:span[@class="course-tit"]');
        $course_ids = $xpath->query('//xhtml:a/@data-coursecontentid');

        $listTitle = array();
        $listId = array();

        foreach ($titles as $node) {
            $link = $node->nodeValue;
            $listTitle[] = $link;
        }

        foreach ($course_ids as $node) {
            $link = $node->nodeValue;
            $listId[] = $link;
        }

        $listRet = array();

        for ( $i = 0; $i < count( $listTitle ); $i++ ) {
            // $ret = '{ "id" : "' . $listId[$i] . '", "title" : "' . $listTitle[$i] . '"},';
            $ret = sprintf( '{ "id" : "%s", "title" : "%s"},', $listId[$i], $listTitle[$i]);

            $retResult = $retResult . $ret;
        }        
      }
      $retResult = rtrim(trim($retResult), ',') . ' ]}';
      return $retResult;
    }
}
