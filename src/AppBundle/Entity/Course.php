<?php
// src/AppBundle/Entity/Category.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BaseModel;
use Acme\Bundle\MobileBundle\Entity;

/**
  * @ORM\Entity
  * @ORM\Table(name="course")
  */
class Course extends BaseModel
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(type="string", length=30)
    */
    protected $title;

    /**
    * @ORM\Column(type="string", length=100)
    */
    protected $photo;

    /**
    * @ORM\Column(type="string", length=100)
    */
    protected $duration;


    /**
      * @ORM\ManyToOne(targetEntity="\Acme\Bundle\MobileBundle\Entity\Teacher", inversedBy="courses")
      * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
      */
    protected $teacher;

    private $isSave;

    public function __construct() {
        parent::__construct();
        $this->isSave = false;
        $this->title = 'empty';
        $this->photo = 'empty';
        $this->duration = '0:0:0';
    }
    public function getSave()
    {
        return $this->isSave;
    }
    public function setSave()
    {
        $this->isSave = true;
    }

    /**
     * Set teacher
     *
     * @param \Acme\Bundle\MobileBundle\Entity\Teacher $teacher
     *
     * @return Course
     */
    public function setTeacher(\Acme\Bundle\MobileBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \Acme\Bundle\MobileBundle\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Course
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Course
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return Course
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }
}
