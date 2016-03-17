<?php

namespace Acme\Bundle\MobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GoodsController extends Controller
{
  /**
   * @Route("/account/goods")
   */
 public function accountAction(Request $request)
    {
    
      $em = $this->getDoctrine()->getManager();
      $goods = $em->getRepository('AppBundle:Goods')->findAll();

      $lst = array();

      foreach($goods as $key => $good)
      {
        $lst[] = sprintf('{"id":"%s","goodsname":"%s","goodsnumber":"%s","soldnumber":"%s","goodsprice":"%s","goodsphoto":"%s"}', 
            $good->getId(), 
            $good->getGoodsName(), 
            $good->getGoodsnumber(), 
            $good->getSoldnumber(), 
            $good->getGoodsprice(), 
            $good->getGoodsphoto()
        );
      }

      $content = sprintf('{"code":0,"message":"succeed!","result":{"list":[%s]}}', implode(',', $lst));
       
      return new Response($content);
    }
}