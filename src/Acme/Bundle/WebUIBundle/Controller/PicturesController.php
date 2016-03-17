<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Pictures;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;

class PicturesController extends Controller
{

    /**
    * @Template()
    */
    public function indexAction(Request $request)
    {      
  
        $em = $this->getDoctrine()->getManager();
        $pictures = $em->getRepository('AppBundle:Pictures')->findAll();

        $delete_form = $this->createFormBuilder()
                ->setMethod('DELETE')
                ->getForm();
                
        return array( 'pictures' => $pictures,'delete_form' => $delete_form->createView());
    }

    /**
    * @Template()
    */
    public function newAction(Request $request)
    {      
        $picture = new Pictures();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($picture)
                    ->add('photo', null)         
                    ->getForm();

        $new_form->handleRequest($request);

        if ($new_form->isSubmitted() && $new_form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($picture);
            $entityManager->flush();

            return $this->redirectToRoute('pictures_index_path');
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

        $pictures = $em->getRepository('AppBundle:Pictures')->find($id);

        $form = $this->createDeleteForm($pictures);

        $form->handleRequest($request);

        $em->remove($pictures);
        $em->flush();

        return $this->redirectToRoute('pictures_index_path');
    }

    private function createDeleteForm($pictures)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pictures_delete_path', array('id' => $pictures->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}

