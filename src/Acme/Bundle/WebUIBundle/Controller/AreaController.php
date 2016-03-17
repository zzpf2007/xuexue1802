<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Area;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AreaController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {     

        $em = $this->getDoctrine()->getManager();

        $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();

        $areas = $em->getRepository('AppBundle:Area')->findAll();
        $cameras = $em->getRepository('AppBundle:Camera')->findAll();
        return array( 'areas' => $areas, 'cameras' => $cameras, 'delete_form' => $delete_form->createView());
    }

   /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $camera = $em->getRepository('AppBundle:Camera')->find($id);

      $delete_form = $this->createDeleteForm($camera);
    }
    
    /**
     * @Template()
     */
     public function newAction(Request $request)
     {
        $area = new Area();
        $new_form = $this->createFormBuilder($area)
                    ->add('name', null)         
                    ->getForm();

        $new_form->handleRequest($request);

        if ($new_form->isSubmitted() && $new_form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($area);
            $entityManager->flush();

            return $this->redirectToRoute('area_index_path');
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
        $area = $em->getRepository('AppBundle:Area')->find($id);

        $form = $this->createDeleteForm($area);

        $form->handleRequest($request);

        $em->remove($area);
        $em->flush();



        return $this->redirectToRoute('area_index_path');
    }

    private function createDeleteForm($area)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('area_delete_path', array('id' => $area->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

