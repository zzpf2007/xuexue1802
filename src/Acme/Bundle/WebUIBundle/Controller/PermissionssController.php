<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Authgroupaccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PermissionssController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {     
      $em = $this->getDoctrine()->getManager();
      $accesss =$em->getRepository('AppBundle:Authgroupaccess')->findall();
      return array('accesss' => $accesss);
    }




}

