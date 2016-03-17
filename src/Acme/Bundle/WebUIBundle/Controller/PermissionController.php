<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Authrole;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PermissionController extends Controller
{

    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {        
       $em = $this->getDoctrine()->getManager();
       $rules = $em->getRepository('AppBundle:Authrole')->findall();

        $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();

       return array('rules' => $rules,'delete_form' => $delete_form->createView());
    }
      
    /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rule = $em->getRepository('AppBundle:Authrole')->find($id);

        $edit_form = $this->createFormBuilder($rule)
                ->add('name', null)
                ->add('title', null)
                ->add('type', null)  
                ->add('status', null)        
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
        
            $em->persist($rule);
            $em->flush();
            return $this->redirectToRoute('authrule_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView()
        );

        // return array( 'camera' => $camera );
    }

    /**
     * @Template()
     */
    public function alterAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rule = $em->getRepository('AppBundle:Authrole')->find($id);

        $edit_form = $this->createFormBuilder($rule)
                ->add('uid', null)     
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
        
            $em->persist($rule);
            $em->flush();
            return $this->redirectToRoute('authrule_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView()
        );

        // return array( 'camera' => $camera );
    }

    /**
     * @Template()
     */
     public function newAction(Request $request)
     {
        $rule = new Authrole();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($rule)
                    ->add('name', null) 
                    ->add('title', null) 
                    ->add('type', null) 
                    ->add('status',null) 
                    ->add('uid',null)     
                    ->getForm();

        $new_form->handleRequest($request);

        if ($new_form->isSubmitted() && $new_form->isValid()) {

            $data = $new_form->getData();

            //var_dump($data->getTitle());
            //exit;

            $rule = new Authrole();
            $rule->setName($data->getName());
            $rule->setTitle($data->getTitle());
            $rule->setType($data->getType());
            $rule->setStatus($data->getStatus());
            $rule->setUid($data->getUid());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rule);
            $entityManager->flush();

            return $this->redirectToRoute('authrule_index_path');
        }

        return array(
            'new_form' => $new_form->createView()
        ); 
      }

    /**
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rule = $em->getRepository('AppBundle:Authrole')->find($id);

        $form = $this->createDeleteForm($rule);

        $form->handleRequest($request);

        $em->remove($rule);
        $em->flush();

        return $this->redirectToRoute('authrule_index_path');
    }

    private function createDeleteForm($rule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('authrule_delete_path', array('id' => $rule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}

