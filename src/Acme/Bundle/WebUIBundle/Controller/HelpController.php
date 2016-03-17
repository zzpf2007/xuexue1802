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

class HelpController extends Controller
{

      /**
     * @Template()
     */

     public function newAction(Request $request)
     {
        $help = new Help();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($help)
                    ->add('title', null) 
                    ->add('link', null)           
                    ->getForm();

        $new_form->handleRequest($request);

        if ($new_form->isSubmitted() && $new_form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($help);
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
        $help = $em->getRepository('AppBundle:Help')->find($id);

        $form = $this->createDeleteForm($help);

        $form->handleRequest($request);

        $em->remove($help);
        $em->flush();



        return $this->redirectToRoute('friendly_index_path');
    }

    private function createDeleteForm($help)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('help_delete_path', array('id' => $help->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



}

