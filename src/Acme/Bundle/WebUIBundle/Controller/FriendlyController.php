<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Friendly;
use AppBundle\Entity\Learn;
use AppBundle\Entity\Help;
use AppBundle\Entity\Partner;
use AppBundle\Entity\Down;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;

class FriendlyController extends Controller
{

   /**
    * @Template()
    */
    public function indexAction(Request $request)
    {      
        
        $em = $this->getDoctrine()->getManager();

        $friendlys = $em->getRepository('AppBundle:Friendly')->findAll();

        $learns = $em->getRepository('AppBundle:Learn')->findAll();

        $helps = $em->getRepository('AppBundle:Help')->findAll();

        $partners = $em->getRepository('AppBundle:Partner')->findAll();

        $downs = $em->getRepository('AppBundle:Down')->findAll();

        $delete_form = $this->createFormBuilder()
                ->setMethod('DELETE')
                ->getForm();

        return array( 'friendlys' => $friendlys,'learns' => $learns,'helps' => $helps,'partners' => $partners,'downs' => $downs,'delete_form' => $delete_form->createView());

    }

     /**
     * @Template()
     */

     public function newAction(Request $request)
     {
        $friendly = new Friendly();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($friendly)
                    ->add('title', null)  
                    ->add('link', null)            
                    ->getForm();

        $new_form->handleRequest($request);

        if ($new_form->isSubmitted() && $new_form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($friendly);
            $entityManager->flush();

            return $this->redirectToRoute('friendly_index_path');
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
        $friendly = $em->getRepository('AppBundle:Friendly')->find($id);

        $form = $this->createDeleteForm($friendly);

        $form->handleRequest($request);

        $em->remove($friendly);
        $em->flush();



        return $this->redirectToRoute('friendly_index_path');
    }

    private function createDeleteForm($friendly)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('friendly_delete_path', array('id' => $friendly->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



}

