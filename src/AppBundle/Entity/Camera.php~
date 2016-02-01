<?php
// src/AppBundle/Entity/Camera.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Area;


/**
  * @ORM\Entity()
  * @ORM\Table(name="camera")
  */
class Camera 
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
    * @ORM\Column(type="string")
    */
    protected $devDesc;

    /**
    * @ORM\Column(type="string")
    */
    protected $devStatus;

    /**
    * @ORM\Column(type="string")
    */
    protected $devStreanId;

    /**
    * @ORM\Column(type="string")
    * 
    */
    protected $devThumbnail;

    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="cameras")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $area; 

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
     * @return Camera
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
     * Set devDesc
     *
     * @param string $devDesc
     *
     * @return Camera
     */
    public function setDevDesc($devDesc)
    {
        $this->devDesc = $devDesc;

        return $this;
    }

    /**
     * Get devDesc
     *
     * @return string
     */
    public function getDevDesc()
    {
        return $this->devDesc;
    }

    /**
     * Set devStatus
     *
     * @param \int $devStatus
     *
     * @return Camera
     */
    public function setDevStatus($devStatus)
    {
        $this->devStatus = $devStatus;

        return $this;
    }

    /**
     * Get devStatus
     *
     * @return \int
     */
    public function getDevStatus()
    {
        return $this->devStatus;
    }

    /**
     * Set devStreanId
     *
     * @param string $devStreanId
     *
     * @return Camera
     */
    public function setDevStreanId($devStreanId)
    {
        $this->devStreanId = $devStreanId;

        return $this;
    }

    /**
     * Get devStreanId
     *
     * @return string
     */
    public function getDevStreanId()
    {
        return $this->devStreanId;
    }

    /**
     * Set devThumbnail
     *
     * @param string $devThumbnail
     *
     * @return Camera
     */
    public function setDevThumbnail($devThumbnail)
    {
        $this->devThumbnail = $devThumbnail;

        return $this;
    }

    /**
     * Get devThumbnail
     *
     * @return string
     */
    public function getDevThumbnail()
    {
        return $this->devThumbnail;
    }

    /**
     * Set aid
     *
     * @param integer $aid
     *
     * @return Camera
     */
    public function setAid($aid)
    {
        $this->aid = $aid;

        return $this;
    }

    /**
     * Get aid
     *
     * @return integer
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * Set area
     *
     * @param \AppBundle\Entity\area $area
     *
     * @return Camera
     */
    public function setArea(\AppBundle\Entity\area $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \AppBundle\Entity\area
     */
    public function getArea()
    {
        return $this->area;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Camera
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }
}
