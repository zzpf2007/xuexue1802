<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;

class MobileController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {        
        $categories = $this->getHomeCategory();

        // $courses = $this->getHomeCourses();
        // $courses = array_slice( $courses, 0, 4 );

        // var_dump($courses);
        $courses01 = $this->getCourse( 207470 );
        $courses01 = array_slice( $courses01, 0, 4 );
        $courses02 = $this->getCourse( 207512 );
        $courses02 = array_slice( $courses02, 0, 4 );
        $courses03 = $this->getCourse( 207471 );
        $courses03 = array_slice( $courses03, 0, 4 );
        $teachers = $this->getTeachers();
        $teachers = array_slice( $teachers, 0, 4 );
        return array( 'categories' => $categories, 'courses01' => $courses01, 'courses02' => $courses02, 'courses03' => $courses03, 'teachers' => $teachers ); //$categories );
        // return array( "categories" => $categories, "courses" => $courses );
    }

    /**
     * @Template()
     */
    public function categoryAction( Request $request )
    {
        $categories = $this->getRootCategory();    
        unset( $categories[0] ); 

        $courseArray = array();
        foreach ($categories as $item) {
            $course = $this->getCourse( $item->id );
            $courseArray[] = $course;
        }
        return array( 'categories' => $categories, 'courseArray' => $courseArray );
    }

    /**
     * @Template()
     */
    public function courseAction( Request $request, $id )
    {
        $courses = $this->getCourse( $id );
        
        return array( 'courses' => $courses );
    }

    /**
     * @Template()
     */
    public function teacherAction( Request $request )
    {
        $teachers = $this->getTeachers();
        return array( 'teachers' => $teachers );
    }

    /**
     * @Template()
     */
    public function teacherinfoAction( Request $request, $id )
    {
        $teacher = $this->getTeachers( $id );
        return array( 'teacher' => $teacher );
    }

    /**
     * @Template()
     */
    public function aboutAction()
    {
        return array( ); 
    }

    /**
     * @Template()
     */
    public function infoAction()
    {
        $categories = $this->getRootCategory();    
        unset( $categories[0] ); 
        return array( 'categories' => $categories ); 
    }

    private function getHomeCategory()
    {
        $content = file_get_contents('http://www.xuekaotong.cn/api/mobile/home/categories');

        $result = array();
        try {
            $retJson = WebJson::stringToJson($content);
            $result = $retJson->{'result'}->{'list'};
        } catch (Exception $e) {
        }
        return $result;
    }

    private function getHomeCourses()
    {
        $content = file_get_contents('http://www.xuekaotong.cn/api/mobile/home/courses');

        $result = array();
        try {
            $retJson = WebJson::stringToJson($content);
            $result = $retJson->{'result'}->{'list'};
        } catch (Exception $e) {
        }
        return $result;
    }

    private function getRootCategory()
    {
        // $entityRepo = $this->getDoctrine()
        //                ->getRepository('AppBundle:Category');

        // $item = $entityRepo->findOneBy(array('type' => 'root'), array('updatedAt' => 'DESC'));

        // $content = $item->getMobileJson();

        $item = new CategoryRootResponse( $this->container );
        $content = $item->getResponse();

        $result = array();
        try {
            $retJson = WebJson::stringToJson($content);
            $result = $retJson->{'result'};            
        } catch (Exception $e) {
            $result = array();
        }
        
        // return $content;
        return $result;
    }

    private function getCourse( $id )
    {
        // $entityRepo = $this->getDoctrine()
        //                ->getRepository('AppBundle:Category');

        // $item = $entityRepo->findOneBy(array('ablesky_id' => $id), array('updatedAt' => 'DESC'));

        // if ( !$item ) return array();

        $item = new CategoryChildResponse( $this->container, $id );

        $content = $item->getResponse();
        // var_dump($content);
        $content = strip_tags( $content );

        $result = array();
        try {
            $retJson = WebJson::stringToJson($content);
            $result = $retJson->{'result'};            
        } catch (Exception $e) {
            $result = array();
        }
        // return $content;
        return $result;
        // return $content;
    }

    private function getTeachers( $id = null)
    {
        $url = '';
        if ( !isset($id) ) {
            $url = 'http://www.xuekaotong.cn/api/mobile/home/teachers';
        } else {
            $url = 'http://www.xuekaotong.cn/api/mobile/home/teachers/' . $id;
        }

        // $restClient = $this->container->get('ci.restclient');
        // $response = $restClient->get($url);

        // $content = $response->getContent();
        $content = file_get_contents( $url );
        // var_dump($content);
        $result = array();
        try {
            $retJson = WebJson::stringToJson($content);
            if ( !isset($id) ) {
                $result = $retJson->{'result'}->{'list'};
            } else {
                $result = $retJson->{'result'};
            }
        } catch (Exception $e) {
            $result = array();
        }        
        return $result;
    }

    private function getTeachersById()
    {
        $url = 'http://www.xuekaotong.cn/api/mobile/home/teachers';
        $restClient = $this->container->get('ci.restclient');
        $response = $restClient->get($url);

        $content = $response->getContent();
        // var_dump($content);
        $result = array();
        try {
            $retJson = WebJson::stringToJson($content);
            $result = $retJson->{'result'}->{'list'};
        } catch (Exception $e) {
            $result = array();
        }        
        return $result;
    }
}

