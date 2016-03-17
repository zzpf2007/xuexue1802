<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Text;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 *
 * @Route("/")
 */
class TextController extends Controller
{
    /**
     * @Route("/indexx")

     */
    public function createText()
    {
        $post=new Text();
        $post->setName('Text');
        $post->setTitle('content');
        $post->setAge(12);


        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush(); 

        return $this->render('AppBundle:Front:index.html.twig');    
    }


       /**
     * @Route("/indexxx")

     */

       public function indexAction()
    {

       $em = $this->getDoctrine()->getManager();
       $pro = $em->getRepository('AppBundle:Text')->findOneBy(array('id'=>1));
 
       //$pro->setAge(30);

      //  $em->persist($pro);
       // $em->flush();
              
        return $this->render('AppBundle:Front:index.html.twig');
    }

      /**
     * @Route("/indexxxx")

     */

       public function indeAction()
    {

       $em = $this->getDoctrine()->getManager();
       $pro = $em->getRepository('AppBundle:Text')->findOneBy(array('id'=>2));
 
        $em->remove($pro);
        $em->flush();
              
        return $this->render('AppBundle:Front:index.html.twig');
    }


     /**
     * @Route("/inde")

     */

       public function inAction()
    {

        $em = $this->getDoctrine()->getManager();
       $pro = $em->getRepository('AppBundle:Text')->findOneBy(array('id'=>1));
 
             
        return $this->render('AppBundle:Front:index.html.twig',array('pro' => $pro));
    }

}
