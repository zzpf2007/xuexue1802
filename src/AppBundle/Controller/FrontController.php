<?php

namespace AppBundle\Controller;

// use AppBundle\Entity\Post;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Utility\WebUtility\WebJson;

class FrontController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $categories = $this->getRootCategory();
        unset( $categories[0] );
        // $item = count($categories);
        // var_dump($categories);
        $courses01 = $this->getCourse( 207470 );
        $courses01 = array_slice( $courses01, 0, 6 );
        $courses02 = $this->getCourse( 207512 );
        $courses02 = array_slice( $courses02, 0, 6 );
        $courses03 = $this->getCourse( 207471 );
        $courses03 = array_slice( $courses03, 0, 6 );
        $teachers = $this->getTeachers();
        $teachers = array_slice( $teachers, 0, 10 );
        // var_dump( $courses );
        return array( 'categories' => $categories, 'courses01' => $courses01, 'courses02' => $courses02, 'courses03' => $courses03, 'teachers' => $teachers ); //$categories );
    }

    /**
     * @Template()
     */
    public function courseAction( Request $request )
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
    public function teacherAction( Request $request )
    {
        $categories = $this->getRootCategory();    
        unset( $categories[0] ); 
        $teachers = $this->getTeachers();
        return array( 'categories' => $categories, 'teachers' => $teachers );
    }

    /**
     * @Template()
     */
    public function aboutAction()
    {
        $categories = $this->getRootCategory();    
        unset( $categories[0] ); 
        return array( 'categories' => $categories ); 
    }


    public function userAction(Request $request)
    {
        $userRepo = $this->getDoctrine()
                   ->getRepository('AppBundle:User');
        $users = $userRepo->findAll();
        $result = '';
        foreach( $users as $user ) {
            $result = $result . sprintf("username: %s, email: %s, mobile: %s </br>", $user->getUsername(), $user->getEmail(), $user->getMobile() );
        }
        return new Response( "Users List:</br>" . $result );
    }

    public function showAction(Request $request)
    {
        $restClient = $this->container->get('ci.restclient');
        // $response = $restClient->get('http://www.baidu.com');
        $payloads = 'data=[orgId:123]&timestamp=123&accessToken=9876543';
        $data1 = array("orgId" => "100");
        // $post_data_01 = array( "data" => json_encode($data1), "timestamp" => "456789", "accessToken" => "987654321");
        $post_data_01 = array( "data" => "100", "timestamp" => "456789", "accessToken" => "987654321");
        // $post_data = array( "data" => "234", "timestamp" => "456789", "accessToken" => "987654321");
        // $post_data = json_encode($post_data);
        // $payloads = "{data:100, timestamp:456789, accessToken:987654321}";
        // $post_data = "{data:100, timestamp:456789, accessToken:987654321}";
        $post_data = http_build_query($post_data_01);
        // $post_data = json_encode($post_data);

        $response = $restClient->post('http://accliapac1.cloudapp.net/api/user', $post_data, array(CURLOPT_CONNECTTIMEOUT => 30));
        $content = $response->getContent();
        $data = $content;
        // $data = join(' ', explode(' ', $content));

        // $json_data = json_decode($data);
        // $content = '{"data": 12345}';
        // $json_data = json_decode($content);
        // $data = $json_data->{'data'};//["data"];
        // $data = $post_data_01["data"];
        // $data = array_reverse ( explode(' ', $content) );
        // $data = implode(' ', $data);
        // $data = strtoupper($data);

        // return new Response("Content: " . $restClient);
        // $response->send();
        return new Response("Content: " . $data );
    }

    public function testAction( Request $request )
    {
        // $retArray = $this->container->getParameter('ci.restclient.curl.defaults');
        $retArray = $this->container->getParameter('web_ui.homepage');
        var_dump($retArray);

        $result = '';
        // foreach( $retArray as $key => $value ) {
        //     $result = $result . sprintf("key: %s, value: %s </br>", $key, $value );
        // }
getMobileJson();
        // $result = $retArray['A_TEST_STRING'];
        return new Response( "Key Value List:</br>" . $result );
    }

    private function getRootCategory()
    {
        $entityRepo = $this->getDoctrine()
                       ->getRepository('AppBundle:Category');

        $item = $entityRepo->findOneBy(array('type' => 'root'), array('updatedAt' => 'DESC'));

        $content = $item->getMobileJson();

        $retJson = WebJson::stringToJson($content);

        $result = $retJson->{'result'};
        // return $content;
        return $result;
    }

    private function getCourse( $id )
    {
        $entityRepo = $this->getDoctrine()
                       ->getRepository('AppBundle:Category');

        $item = $entityRepo->findOneBy(array('ablesky_id' => $id), array('updatedAt' => 'DESC'));

        if ( !$item ) return array();

        $content = $item->getMobileJson();
        // var_dump($content);
        $content = strip_tags( $content );

        $retJson = WebJson::stringToJson($content);

        $result = $retJson->{'result'};
        // return $content;
        return $result;
        // return $content;
    }

    private function getTeachers()
    {
        $url = 'http://www.xuekaotong.cn/api/mobile/home/teachers';
        $restClient = $this->container->get('ci.restclient');
        $response = $restClient->get($url);

        $content = $response->getContent();
        // var_dump($content);
        $retJson = WebJson::stringToJson($content);

        $result = $retJson->{'result'}->{'list'};
        return $result;
    }
}

