<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Camerauser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CamerauserController extends Controller
{
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

        $camerauser = $user->getCamerauser();

        if(!$camerauser){
            
            $camerauser = new Camerauser();
        }

        $edit_form = $this->createFormBuilder($camerauser)      
                ->add('devId',null)   
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {

            $camerauser->setUser($user);
            $em->persist($camerauser);
            $em->flush();
            return $this->redirectToRoute('user_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView(),
            'user_id' => $id
        );
        
    }
}

