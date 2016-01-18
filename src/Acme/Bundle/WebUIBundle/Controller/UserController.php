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

class UserController extends Controller
{
    /**
     * @Template()
     */
    public function profileAction(Request $request)
    {

    }

}

