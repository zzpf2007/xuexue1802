<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebUtility\WebAuto;

class WebApiControllerTest extends WebTestCase
{
  public function testUserApi()
  {
    // $client = static::createClient();
    // $url = '/api/user';

    // // $payload = '{ "data":{"type":"register"} }';
    // $payload = array();
    // $payload['data'] = '{"type":"register"}';
    // $crawler = $client->request('POST', $url, $payload );

    // $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // $content = $client->getResponse()->getContent();

    // print_r("/n WebApiControllerTest:testUserApi:$content: " . $content);
  }

  public function testCategory()
  {
    // $client = static::createClient();
    // $url = '/api/school/categories';

    // $crawler = $client->request('GET', $url);

    // $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // $content = $client->getResponse()->getContent();

    // print_r("/n WebApiControllerTest:testCategory:$content: " . $content);
  }

  public function testGetCoursesByCategoryId()
  {
    // $client = static::createClient();
    // $url = '/api/school/categories/207470';

    // $crawler = $client->request('GET', $url);

    // $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // $content = $client->getResponse()->getContent();

    // print_r("/n WebApiControllerTest:testGetCoursesByCategoryId:$content: " . $content);
  }

  public function testGetCoursesDetails()
  {
    
  }
}
