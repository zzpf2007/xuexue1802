<?php
// src/AppBundle/Entity/Camerauser.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;


/**
  * @ORM\Entity()
  * @ORM\Table(name="camerauser")
  */
class Camerauser
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(type="string")
    */
    protected $devId;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="camerauser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $user; 


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set devId
     *
     * @param string $devId
     *
     * @return Camerauser
     */
    public function setDevId($devId)
    {
        $this->devId = $devId;

        return $this;
    }

    /**
     * Get devId
     *
     * @return string
     */
    public function getDevId()
    {
        return $this->devId;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Camerauser
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
