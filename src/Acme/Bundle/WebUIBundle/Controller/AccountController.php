<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\Account;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;

class AccountController extends Controller
{

   /**
    * @Template()
    */
    public function indexAction(Request $request)
    {      
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        $qb = $em->getRepository('AppBundle:User')->createQueryBuilder('n')->orderby('n.id','asc');
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $request->query->getInt('page', 1),5);

        return array('pagination' => $pagination, 'users' => $users);
    }

    /**
    * @Template()
    */
    public function personAction(Request $request)
    {      
       $user = $this->getUser();
       return array( 'user' => $user);
    }

   /**
    * @Template()
    */
    public function editAction(Request $request, $id)
    {      
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        if (!$user) {
            return ;
        }

        $account = $user->getAccount();

        if (!$account) {

            $account = new Account(); 
        }

        $edit_form = $this->createFormBuilder($account)
                ->add('photo', null)
                ->add('name', null)
                ->add('signature',null)
                ->add('phonenumber', null)
                ->add('othernumber', null)         
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {

            $account->setUser($user);
            $em->persist($account);
            $em->flush();
            return $this->redirectToRoute('account_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView(),
            'user_id' => $id
        );
    }

    /**
    * @Template()
    */
    public function modifyAction(Request $request, $id)
    {      
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        if (!$user) {
            return ;
        }

        $account = $user->getAccount();

        if (!$account) {

            $account = new Account(); 
        }

        $edit_form = $this->createFormBuilder($account)
                ->add('photo', null)
                ->add('name', null)
                ->add('signature',null)
                ->add('phonenumber', null)
                ->add('othernumber', null)         
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {

            $account->setUser($user);
            $em->persist($account);
            $em->flush();
            return $this->redirectToRoute('account_person_path');
        }

        return array(            
            'edit_form' => $edit_form->createView(),
            'user_id' => $id
        );
    }


}

