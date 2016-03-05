<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Authgroup;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PermissionsController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {     
      $em = $this->getDoctrine()->getManager();
      $groups =$em->getRepository('AppBundle:Authgroup')->findall();
      $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();
      return array('groups' => $groups,'delete_form' => $delete_form->createView());
    }

      /**
     * @Template()
     */
    public function alterAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('AppBundle:Authgroup')->find($id);

        $edit_form = $this->createFormBuilder($group)
                ->add('uid', null)     
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
        
            $em->persist($group);
            $em->flush();
            return $this->redirectToRoute('authgroup_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView()
        );

        // return array( 'camera' => $camera );
    }


    /**
     * @Template()
     */
    public function editAction(Request $request, $id) 
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('AppBundle:Authgroup')->find($id);

        $edit_form = $this->createFormBuilder($group)
                ->add('title', null)
                ->add('rules', null)  
                ->add('status', null)        
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
        
            $em->persist($group);
            $em->flush();
            return $this->redirectToRoute('authgroup_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView()
        );

        // return array( 'camera' => $camera );
    }
     
    /**
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('AppBundle:Authgroup')->find($id);

        $form = $this->createDeleteForm($group);

        $form->handleRequest($request);

        $em->remove($group);
        $em->flush();

        return $this->redirectToRoute('authgroup_index_path');
    }

    private function createDeleteForm($group)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('authgroup_delete_path', array('id' => $group->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Template()
     */
      public function newAction(Request $request)
    {      
        $em = $this->getDoctrine()->getManager();
        $rules = $em->getRepository('AppBundle:Authrole')->findAll();
        $attr="";    
        foreach($rules as $rule)
        {
            $attr[$rule->getId()]=$rule->getName();
        }

        $group = new Authgroup();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($group)             
                    ->add('title', null)
                    ->add('rules','choice',array('attr'=>array('style'=>'display:block;'),
                          'multiple'=>true,
                          'expanded'=>true,
                          'choices'=>$attr))   
                    ->add('status', null) 
                    ->add('uid',null)    
                    ->getForm();

        if ($request->getMethod() == "POST") {  

            $formData = $request->request->get($new_form->getName());  
            $new_form->bind($formData); 
        } 

        if ($new_form->isSubmitted() && $new_form->isValid()) {
            
                $strRules =  implode(',',$formData['rules']);
                $group = new Authgroup();
                $group->setTitle($formData['title']);
                $group->setRules($strRules); 
                $group->setStatus($formData['status']);
                $group->setUid($formData['uid']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($group);
            $entityManager->flush();
            return $this->redirectToRoute('authgroup_index_path');
        }
        return array(
            'new_form' => $new_form->createView()
        );
    }
}

