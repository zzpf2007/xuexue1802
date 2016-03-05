<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Course;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CourseController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {        
       $em = $this->getDoctrine()->getManager();
       $courses = $em->getRepository('AppBundle:Course')->findAll();

       $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();


       return array('courses' => $courses,'delete_form' => $delete_form->createView());
    }

    /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Course')->find($id);

        $edit_form = $this->createFormBuilder($course)
                ->add('title', null)
                ->add('photo', null)
                ->add('duration', null)  
                ->add('tcVideoUrl', null)        
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
        
            $em->persist($course);
            $em->flush();
            return $this->redirectToRoute('course_index_path');
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
        $course = $em->getRepository('AppBundle:Course')->find($id);

        $form = $this->createDeleteForm($course);

        $form->handleRequest($request);

        $em->remove($course);
        $em->flush();

        return $this->redirectToRoute('course_index_path');
    }

    private function createDeleteForm($course)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course_delete_path', array('id' => $course->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Template()
     */

     public function createAction(Request $request)
     {

        $em = $this->getDoctrine()->getManager();
        $teachers = $em->getRepository('AppBundle:Teacher')->findAll();

        $attr=array('empty_value' => '请选择');    

        foreach($teachers as $teacher)
        {
            $attr[$teacher->getId()]=$teacher->getName();
        }

       // var_dump($attr);
       // die;
        $course = new Course();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($course)
                    ->add('teacher', 'choice', array('choices' => $attr))
                    ->add('title', null) 
                    ->add('photo', null) 
                    ->add('duration', null) 
                    ->add('tcVideoUrl', null)  
                    ->add('ablesky_id', null)         
                    ->getForm();

        $teacher = null;

        if ($request->getMethod() == "POST") {  

            $formData = $request->request->get($new_form->getName());
            $teacher = $em->getRepository('AppBundle:Teacher')->findOneBy(array('id'=>$formData['teacher']));
            $formData['teacher'] = null;      
            $new_form->bind($formData); 

        } 

        if ($new_form->isSubmitted() && $new_form->isValid()) {
          
            $course->setTeacher($teacher);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index_path');
        }

        return array(
            'new_form' => $new_form->createView()
        ); 
      }
}

