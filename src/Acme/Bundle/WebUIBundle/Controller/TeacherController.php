<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Teacher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TeacherController extends Controller
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
             'SELECT u FROM AppBundle:Teacher u WHERE u.name LIKE :name ORDER BY u.id DESC'   
             )->setParameter('name','%'.$_POST['name'].'%');   
           
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

        $teachers = $em->getRepository('AppBundle:Teacher')->findAll();

        $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();

        $qb = $em->getRepository('AppBundle:Teacher')->createQueryBuilder('n');
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $request->query->getInt('page', 1),5);

        return array('pagination' => $pagination,'teachers' => $teachers,'delete_form' => $delete_form->createView());
    }

       /**
     * @Template()
     */

     public function newAction(Request $request)
     {
        $teacher = new Teacher();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($teacher)
                    ->add('name', null) 
                    ->add('major', null) 
                    ->add('photo', null) 
                    ->add('ablesky_id',null)     
                    ->getForm();

        $new_form->handleRequest($request);

        if ($new_form->isSubmitted() && $new_form->isValid()) {

            $data = $new_form->getData();

            $teacher = new Teacher();
            $teacher->setName($data->getName());
            $teacher->setMajor($data->getMajor());
            $teacher->setPhoto($data->getPhoto());
            $teacher->setAbleskyId($data->getAbleskyId());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teacher);
            $entityManager->flush();

            return $this->redirectToRoute('teacher_index_path');
        }

        return array(
            'new_form' => $new_form->createView()
        ); 
      }

   /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $teacher = $em->getRepository('AppBundle:Teacher')->find($id);

        $edit_form = $this->createFormBuilder($teacher)
                ->add('name', null)
                ->add('major', null)
                ->add('photo', null)        
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
        
            $em->persist($teacher);
            $em->flush();
            return $this->redirectToRoute('teacher_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView()
        );

    }


     /**
     * @Template()
     */
     public function createAction(Request $request)
     {
        
     }

     /**
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $teacher = $em->getRepository('AppBundle:Teacher')->find($id);

        $form = $this->createDeleteForm($teacher);

        $form->handleRequest($request);

        $em->remove($teacher);
        $em->flush();

        return $this->redirectToRoute('teacher_index_path');
    }

    private function createDeleteForm($teacher)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teacher_delete_path', array('id' => $teacher->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

