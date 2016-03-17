<?php
// src/AppBundle/Entity/Area.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Camera;


/**
  * @ORM\Entity()
  * @ORM\Table(name="area")
  */
class Area 
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
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Camera", mappedBy="area", cascade={"persist", "remove"})
     */
    protected $cameras;

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
     * Set name
     *
     * @param string $name
     *
     * @return Area
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cameras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add camera
     *
     * @param \AppBundle\Entity\Camera $camera
     *
     * @return Area
     */
    public function addCamera(\AppBundle\Entity\Camera $camera)
    {
        $this->cameras[] = $camera;

        return $this;
    }

    /**
     * Remove camera
     *
     * @param \AppBundle\Entity\Camera $camera
     */
    public function removeCamera(\AppBundle\Entity\Camera $camera)
    {
        $this->cameras->removeElement($camera);
    }

    /**
     * Get cameras
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCameras()
    {
        return $this->cameras;
    }
}
