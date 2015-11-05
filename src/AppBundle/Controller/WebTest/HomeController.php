<?php

namespace AppBundle\Controller\WebTest;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Utility\WebTest\WebTestFactory;
use AppBundle\Utility\Check\CheckString;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
  public function indexAction( $name )
  {
    $log = "log:";

    $restClient = $this->container->get('ci.restclient');
    $test = WebTestFactory::getInstance($name, $restClient);

    $log = $test->runTest($restClient);
    // return $this->render('web_test/index.html.twig', array( 'log' => CheckString::check( $log ) ) );
    return new Response(CheckString::check( $log ));
    // return new Response($log);
  }
}
