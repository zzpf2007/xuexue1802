<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TestController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {        
     
       $em=$this->getDoctrine()->getManager();
       $texts = $em->getRepository('AppBundle:Text')->findAll();

       $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();

       return array('texts' => $texts, 'delete_form' => $delete_form->createView());
    }


      /**
     * @Template()
     */
     public function editAction(Request $request, $id)
     {
        $em=$this->getDoctrine()->getManager();
        $text=$em->getRepository('AppBundle:Text')->find($id);

        $edit_form=$this->createFormBuilder($text)
             ->add('name',null)
             ->add('title',null)
             ->add('age',null)
             ->add('save','submit',array('label'=>'修改'))
             ->getForm();

        $edit_form->handleRequest($request);

        if($edit_form->isSubmitted() && $edit_form->isValid()){

            $em->persist($text);
            $em->flush();

            return $this->redirectToRoute('test_index_path');
        }

         return array(
               'edit_form'=>$edit_form->createView()
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
        $text = $em->getRepository('AppBundle:Text')->find($id);

        $form = $this->createDeleteForm($text);

        $form->handleRequest($request);

        $em->remove($text);
        $em->flush();

        return $this->redirectToRoute('test_index_path');
    }

    private function createDeleteForm($text)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('test_index_path', array('id' => $text->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

