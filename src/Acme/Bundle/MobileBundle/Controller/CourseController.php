<?php

namespace Acme\Bundle\MobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
  /**
   * @Route("/account/course/{id}")
   */
  public function accountAction( Request $request, $id)
  {
    $content = "";

    if ( $id ) {
      $em = $this->getDoctrine()->getManager();
      $course = $em->getRepository('AppBundle:Course')->find($id);
    }

    if ( $course ) {

      $teacher = $course->getTeacher();

      $id = $course->getId();
      $title = $course->getTitle();

      $name = $teacher->getName();
      $photo = $teacher->getPhoto();
      //$photo = $course->getPhoto();
      //$duration = $course->getDuration();
      $tcVideoUrl= $course->gettcVideoUrl();


      $content = sprintf('{"code":0,"message":"succeed!","result":{"list":[ {"id":"%s","title":"%s","name":"%s","photo":"%s","tcVideoUrl":"%s"} ]}}'
                         ,$id, $title,$name,$photo,$tcVideoUrl);
    }


    return new Response( $content );
  }

}