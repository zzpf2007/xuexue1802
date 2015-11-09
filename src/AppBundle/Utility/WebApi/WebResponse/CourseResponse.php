<?php

namespace AppBundle\Utility\WebApi\WebResponse;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebApi\WebResponse\WebResponseMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Entity\Category;

class CourseResponse extends WebResponseMode
{
  public function getResponse()
  {
    return "Course Response";
  }
}
