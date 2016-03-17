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

class PartnerController extends Controller
{

    /**
     * @Template()
     */

     public function newAction(Request $request)
     {
        $partner = new Partner();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($partner)
                    ->add('title', null) 
                    ->add('link', null)         
                    ->getForm();

        $new_form->handleRequest($request);

        if ($new_form->isSubmitted() && $new_form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partner);
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
        $partner = $em->getRepository('AppBundle:Partner')->find($id);

        $form = $this->createDeleteForm($partner);

        $form->handleRequest($request);

        $em->remove($partner);
        $em->flush();

        return $this->redirectToRoute('friendly_index_path');
    }

    private function createDeleteForm($partner)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partner_delete_path', array('id' => $partner->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



}

