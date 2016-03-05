<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Group;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;

class GroupController extends Controller
{

   /**
    * @Template()
    */
    public function indexAction(Request $request)
    {      
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('AppBundle:Group')->findAll();

        $user = $this->getUser();
		$userManager = $container->get('fos_user.user_manager');
		$user->addRole('ROLE_ADMIN');
		$userManager->updateUser($user);

		$user = $this->getUser();
		if ($user->hasRole('ROLE_ADMIN'))
		{
		    //do something
		}

        return array('groups' => $groups);
    }

}

