<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Coin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;

class CoinController extends Controller
{
   
   /**
    * @Template()
    */
    public function personAction(Request $request)
    {      
       $user = $this->getUser();
       return array( 'user' => $user);
    }

    /**
    * @Template()
    */
    public function editAction(Request $request,$id)
    {      
  
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($id);

        if(!$user){
           
           return ;
        }

        $coin = $user->getCoin();

        if(!$coin){
            
            $coin = new Coin();
        }

        $edit_form = $this->createFormBuilder($coin)      
                ->add('number',null)
                ->add('balance',null)      
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {

            $coin->setUser($user);
            $em->persist($coin);
            $em->flush();
            return $this->redirectToRoute('account_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView(),
            'user_id' => $id
        );
    }

}

