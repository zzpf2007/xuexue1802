<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebUtility\WebAuto;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
        $this->assertContains('Home page', $client->getResponse()->getContent());
    }

    public function testServer()
    {
        $client = static::createClient();

        // $url = 'http://xkt.jzcnw.com/organizationRedirect.do?action=viewCourseScheduleDetail&organizationId=8778';
        $url = '/';
        $crawler = $client->request('GET', $url);

        // print_r("Nodename: " . $crawler->first()->text());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
        // $content = $client->getResponse()->getContent();
        // $this->assertContains('Home page', $content);
        // print_r($content);
    }

    public function testApiUserPost()
    {
      $client = static::createClient();
      $data = array( "data" => "100", "timestamp" => "456789", "accessToken" => "987654321");
      $crawler = $client->request('POST', '/api/user', $data);
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
      // var_dump($client->getResponse()->getContent());
      $data_value = "100";
      $response_content = $client->getResponse()->getContent();
      // var_dump($response_content);

      // $response_content = '{"data":"100", "timestamp":"456789", "accessToken":"987654321" }';
      $response_json = WebJson::stringToJson($response_content);
      $response_data_value = $response_json->{'data'};
      $this->assertEquals($data_value, $response_data_value);
    }

    public function testAbleSkyGet()
    {
      // $client = static::createClient();
      // $url = '/web/response';

      // $crawler = $client->request('GET', $url);
      // $response_content = $client->getResponse()->getContent();

      // $this->assertEquals(200, $client->getResponse()->getStatusCode());

      // $response_content = WebJson::parseJsonString($response_content);
      // // $response_content = WebJson::stringToJson($response_content);
      // // $response_content = json_decode($response_content);

      // print_r("/n DefaultControllerTest: testAbleSky: response_content: " . $response_content);
    }

    public function testAbleSkyPost()
    {
      // $url = WebAuto::webURL();
      // // print_r($url);

      // $client = static::createClient();
      // $payload = WebAuto::webBuildParamsArray();
      // // $payload = WebAuto::webBuildParams();

      // $crawler = $client->request('POST', $url, $payload);

      // // $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLocalFile()
    {
      // $content = file_get_contents('../../../../../../web/data.txt');
      // print_r($content);
    }
}
