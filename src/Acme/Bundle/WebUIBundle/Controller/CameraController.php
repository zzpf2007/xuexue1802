<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Camera;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CameraController extends Controller
{

     /**
     * @Template()
     */
    public function searchAction(Request $request)
    {


        $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();

         if($_POST){

            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(   
             'SELECT u FROM AppBundle:Camera u WHERE u.devDesc LIKE :devDesc ORDER BY u.id DESC'   
             )->setParameter('devDesc','%'.$_POST['devDesc'].'%');   
           
             $results = $query->getResult(); 
            }
            
           return array('results'=>$results,'delete_form' => $delete_form->createView());
    }


    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {        
        $em = $this->getDoctrine()->getManager();

        $delete_form = $this->createFormBuilder()
                ->setMethod('DELETE')
                ->getForm();

        $cameras = $em->getRepository('AppBundle:Camera')->findAll();


        $qb = $em->getRepository('AppBundle:Camera')->createQueryBuilder('n');
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $request->query->getInt('page', 1),3);


        return array('pagination' => $pagination,'cameras' => $cameras,'delete_form' => $delete_form->createView() );
    }

    /**
     * @Template()
     */
    public function newAction(Request $request)
    {
       
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository('AppBundle:Area')->findAll();

        $areaattr=array('empty_value' => '请选择');    

        foreach($areas as $area)
        {
            $areaattr[$area->getId()]=$area->getName();
        }
              
        $camera = new Camera();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($camera)             
                    ->add('devId', null)
                    ->add('devDesc', null)
                    ->add('devStatus', null)
                    ->add('devStreanId', null)
                    ->add('devThumbnail', null) 
                    ->add('area', 'choice', array('choices' => $areaattr))        
                    ->getForm();
        
        $area = null;

        if ($request->getMethod() == "POST") {  

            $formData = $request->request->get($new_form->getName());
            $area = $em->getRepository('AppBundle:Area')->findOneBy(array('id'=>$formData['area']));
            $formData['area'] = null;      
            $new_form->bind($formData); 

        } 

        if ($new_form->isSubmitted() && $new_form->isValid()) {
          
            $camera->setArea($area);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($camera);
            $entityManager->flush();

            return $this->redirectToRoute('camera_index_path');
        }

        return array(
            'new_form' => $new_form->createView()
        );
    }

    public function createAction(Request $request)
    {
        
    }

    /**
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $camera = $em->getRepository('AppBundle:Camera')->find($id);

        $form = $this->createDeleteForm($camera);

        $form->handleRequest($request);

        $em->remove($camera);
        $em->flush();

        return $this->redirectToRoute('camera_index_path');
    }

    private function createDeleteForm($camera)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('camera_delete_path', array('id' => $camera->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

