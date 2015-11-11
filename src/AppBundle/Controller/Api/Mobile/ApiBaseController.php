<?php

namespace AppBundle\Controller\Api\Mobile;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiFactory;
use AppBundle\Utility\Check\CheckString;
use AppBundle\Utility\WebApi\User\UserApiFactory;
use AppBundle\Utility\WebApi\User\UserApiUtil;

class ApiBaseController extends Controller
{
    public function userAction(Request $request)
    {
      list( $type, $data ) = UserApiUtil::buildRequest( $request );
      $webApi = UserApiFactory::getInstance( $type, $data, $this->container );
      $result = $webApi->getResult();

      return new Response($result);
    }

    public function categoryActoin(Request $request, $id)
    {
      $webApi = WebApiFactory::getInstance('category', $this->container, $id );
      $result = $webApi->getResult();
      return new Response(CheckString::check( $result ));
    }

    public function courseAction(Request $request, $id)
    {
      $webApiCourse = WebApiFactory::getInstance('course', $this->container, $id );
      $result = $webApiCourse->getResult();
      return new Response(CheckString::check( $result ));
    }
}
