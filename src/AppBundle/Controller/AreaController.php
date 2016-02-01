<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Area;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class AreaController extends Controller
{
  public function indexAction(){
        $post=new Area();
       // $post->setName('北京');
        //$post->setName('上海');
       // $post->setName('山西');
        $post->setName('陕西');

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush(); 

        return $this->render('AppBundle:Front:index.html.twig');
  }

}