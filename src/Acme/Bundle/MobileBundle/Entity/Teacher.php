<?php
namespace Acme\Bundle\MobileBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BaseModel;

/**
  * @ORM\Entity
  * @ORM\Table(name="teacher")
  */
class Teacher extends BaseModel
{
    /**
      * @ORM\Column(type="integer")
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="AUTO")
      */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
