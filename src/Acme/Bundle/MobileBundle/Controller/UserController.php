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

      $photo = $account && $account->getPhoto() ? $account->getPhoto() : '100.png';
      $name  = $account && $account->getName() ? $account->getName() : '樱桃小丸子';
      $signature = $account && $account->getSignature() ? $account->getSignature():'';
      $phoneNumber = $account && $account->getPhonenumber() ? $account->getPhonenumber() :'';
      $otherNumber = $account && $account->getOthernumber() ? $account->getOthernumber() :'';

      $balance = $coin && $coin->getBalance() ? $coin->getBalance(): '0.00';
      $number = $coin && $coin->getNumber() ? $coin->getNumber(): '0';
      $userCreatedAt = $user->getCreatedAt()->format('Y-m-d H:i:s');


      $content = sprintf('{"code":0,"message":"succeed!","result":{"photo":"%s","name":"%s","balance":"%s","phoneNumber":"%s","othernumber":"%s","number":"%s","signature":"%s","createdAt":"%s"} }'
                        , $photo, $name, $balance, $phoneNumber, $otherNumber,$number,$signature,$userCreatedAt);
    }

    return new Response( $content );
  }

  /**
   * @Route("/account/sign/{id}")
   */
  public function signAction( Request $request, $id)
  {
    $content = "";

    if ( $id ) {
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('AppBundle:User')->find($id);
    }

    if ( $user ) {

      $account = $user->getAccount();
     
      $signin = $account && $account->getSignin() ? getSignin() :'0';

      $content = sprintf('{"code":0,"message":"succeed!","result":{"signin":"%s"} }'
                        , $signin);
    }

    return new Response( $content );
  }

   /**
   * @Route("/account/coupons/{id}")
   */
  public function couponsAction( Request $request, $id)
  {

    //$content = "";

    //if ( $id ) {
    //  $em = $this->getDoctrine()->getManager();
     // $user = $em->getRepository('AppBundle:Usercoupon')->find($id);
  //  }

   // if ( $user ) {
    
      // $usercoupon = $user->getUsercoupon();

       //var_dump($usercoupon);
       //die;
                         
   // }
    //$content = sprintf('{"code":0,"message":"succeed!","result":{"photo":"%s","name":"%s","balance":"%s","phoneNumber":"%s","othernumber":"%s","number":"%s","signature":"%s","createdAt":"%s"} }'
                        //, $photo, $name, $balance, $phoneNumber, $otherNumber,$number,$signature,$userCreatedAt);
   // return new Response( $content );
  }
}