<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;
use AppBundle\Utility\WebApi\User\ChangePwd;


class UserController extends Controller
{
    /**
     * @Template()
     */
    public function profileAction(Request $request)
    {
         //var_dump($this->getUser());die;

       $user = $this->getUser();
       $name=$user->getUsername();
       $password=$user->getPassword();
       $mobile=$user->getMobile();
       $email=$user->getEmail();
       return array( 'user' => $user);

    }

       /**
     * @Template()
     */
    public function personAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $delete_form = $this->createDeleteForm($user);

        $edit_form = $this->createFormBuilder($user)
                ->add('username', null)
                ->add('mobile', null)
                ->add('email', null)         
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
            // ... perform some action, such as saving the task to the database
            // $data = $edit_form->getData();

            // if ( '' !== $data->getPassword() ) {
            //     $user->setPassword($this->encodePassword($user, $data->getPassword()));
            // }

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }

        return array(            
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView()
        );

        // return array( 'camera' => $camera );
    }

     /**
     * @Template()
     */
    public function completeAction(Request $request)
    {
      if($_POST){

          if($_POST['username']=="admin" && $_POST['password']=="admin"){

               $session = $request->getSession();
               $session->set('value', '1');

             return $this->redirect($this->generateUrl('user_index_path'));
          }

          else if($_POST['username']=="admin" && $_POST['password']!="admin"){
            return "密码错误，请重新输入";
          }

          else if($_POST['username']!="admin" && $_POST['password']=="admin"){
            return "用户名错误，请重新输入";
          }

          else{
            return "输入错误，请重新输入";
          }
           
      }
       
    }

    /**
     * @Template()
     */
    public function searchAction(Request $request)
    {


        $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();

         if($_GET){

            // var_dump($_GET['username']);
            //die;

            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(   
             'SELECT u FROM AppBundle:User u WHERE u.username LIKE :username ORDER BY u.id DESC'   
             )->setParameter('username','%'.$_GET['username'].'%');   
           
             $results = $query->getResult(); 
             //$em->flush();

             //return $query->getArrayResult();
            // var_dump($result);
             //die;
            }
            
           return array('results'=>$results,'delete_form' => $delete_form->createView());
    }

    /**
     * @Template()
     */

    public function indexAction(Request $request)
    {
       // $name=$_SESSION['_sf2_attributes']['value'];
       // echo $name;
       // die;
        $em = $this->getDoctrine()->getManager();

        $delete_form = $this->createFormBuilder()
                      ->setMethod('DELETE')
                      ->getForm();

        $users = $em->getRepository('AppBundle:User')->findAll();
       // echo "<pre>";
       // var_dump($users);
       //echo "</pre>";
       // die;
  
        $qb = $em->getRepository('AppBundle:User')->createQueryBuilder('n');
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $request->query->getInt('page', 1),5);

          
        return array('pagination' => $pagination,'users' => $users,'delete_form' => $delete_form->createView());
    
      
    }

   
    /**
     * @Template()
     */
    public function newAction(Request $request)
    {
        $user = new User();
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $new_form = $this->createFormBuilder($user)
                    ->add('username', null)
                    ->add('password', "password")
                    ->add('mobile', null)
                    ->add('email', null)
                    ->getForm();

        $new_form->handleRequest($request);

        if ($new_form->isSubmitted() && $new_form->isValid()) {
            
            $data = $new_form->getData();

            //var_dump($data->getUsername());
           // exit;

            $user = new User();
            $user->setUsername($data->getUsername());
            $user->setEmail($data->getEmail());
            $user->setMobile($data->getMobile());
            $user->setMobile($data->getDevId());
            $user->setPassword($this->encodePassword($user, $data->getPassword()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index_path');
        }
        return array(
            'new_form' => $new_form->createView()
        );
    }

      private function encodePassword(User $user, $plainPassword)
    {
    $encoder = $this->container->get('security.encoder_factory')
        ->getEncoder($user)
    ;
    return $encoder->encodePassword($plainPassword, $user->getSalt());
    }


      /**
     * @Template()
     */
       public function createAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $edit_form = $this->createFormBuilder($user)
                ->add('password', null)       
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
            // ... perform some action, such as saving the task to the database
             $data = $edit_form->getData();

            if ( '' !== $data->getPassword() ) {
                 $user->setPassword($this->encodePassword($user, $data->getPassword()));
             }

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView(),
        );
    }

      /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $delete_form = $this->createDeleteForm($user);

        $edit_form = $this->createFormBuilder($user)
                ->add('username', null)
                ->add('mobile', null)
                ->add('email', null)         
                ->getForm();

        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
            // ... perform some action, such as saving the task to the database
            // $data = $edit_form->getData();

            // if ( '' !== $data->getPassword() ) {
            //     $user->setPassword($this->encodePassword($user, $data->getPassword()));
            // }

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_index_path');
        }

        return array(            
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView()
        );

        // return array( 'camera' => $camera );
    }


    /**
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->find($id);

        $form = $this->createDeleteForm($users);

        $form->handleRequest($request);

        $em->remove($users);
        $em->flush();

        return $this->redirectToRoute('user_index_path');
    }

    private function createDeleteForm($users)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete_path', array('id' => $users->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * @Template()
     */
    public function adminAction(Request $request)
    {
        $username = 'lzq123456789';

        $form = $this->createFormBuilder()
                ->add('username', null)
                ->add('password', null)
                ->add('rePassword', null)         
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $data = $form->getData();
            var_dump( $data );

            $password = $data['password'];
            $rePassword = $data['rePassword'];

            if ( $password === $rePassword ) {

                $json = sprintf('{ "username":"%s", "newPassword":"%s" }', $username, $password);

                $adminChangePwd = new ChangePwd($this->container, $json);
                var_dump( $adminChangePwd->getResult() );
            }

            // return $this->redirectToRoute('user_index_path');
        }

        return array(            
            'form' => $form->createView()
        );
        
    }
}

