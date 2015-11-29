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
        // getMobileJson();
        // $result = $retArray['A_TEST_STRING'];
        return new Response( "Key Value List:</br>" . $result );
    }
}

