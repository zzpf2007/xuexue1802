<?php

namespace Acme\Bundle\MobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
  /**
   * @Route("/account/info/{id}")
   */
  public function accountAction( Request $request, $id)
  {
    $content = "";

    if ( $id ) {
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('AppBundle:User')->find($id);
    }

    if ( $user ) {
      $account = $user->getAccount();
      $coin = $user->getCoin();

      $photo = $account->getPhoto();
      $name = $account->getName();

      $balance = $coin->getBalance();
      $phoneNumber = $account->getPhonenumber();
      $otherNumber = $account->getOthernumber();
      $userCreatedAt = $user->getCreatedAt()->format('Y-m-d H:i:s');

      $content = sprintf('{"photo":"%s","name":"%s","balance":"%s","phoneNumber":"%s","createdAt":"%s","otherNumber":"%s"}'
                         , $photo, $name, $balance, $phoneNumber, $userCreatedAt, $otherNumber);
    }

    return new Response( $content );
  }

  /**
   * @Route("/camera/{id}")
   */
  public function cameraAction( Request $request, $id)
  {
    $content = "";

    if ( $id ) {
      $em = $this->getDoctrine()->getManager();
      $area = $em->getRepository('AppBundle:Area')->find($id);
    }

    if ( $area ) {
      $cameras = $area->getCameras();

      foreach ($cameras as $camera) {
        # code...
      }
      $devId = $cameras[1]->getDevId();
      $devDesc = $cameras[1]->getDevDesc();

      $content = sprintf('{"devId":"%s","devDesc":"%s"}'
                         , $devId, $devDesc);
    }

    return new Response( $content );
  }

}