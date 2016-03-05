<?php
// src/AppBundle/Entity/Teacher.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BaseModel;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Course;


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

  /**
    * @ORM\Column(type="string", length=30)
    */
  protected $name;

  /**
    * @ORM\Column(type="string", length=10)
    */
  protected $work_exp;

  /**
    * @ORM\Column(type="string", length=100)
    */
  protected $major;

  /**
    * @ORM\Column(type="string", length=100)
    */
  protected $photo;

  /**
    * @ORM\Column(type="boolean")
    */
  protected $valid;

  /**
    * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Course", mappedBy="teacher")
    */
  protected $courses;

  public function __construct()
  {
      parent::__construct();
      $this->courses = new ArrayCollection();
      $this->work_exp = 'empty';
      $this->valid = 'empty';
      // your own logic
  }

    /**
     * Add course
     *
     * @param \AppBundle\Entity\Course $course
     *
     * @return Teacher
     */
    public function addCourse(\AppBundle\Entity\Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \AppBundle\Entity\Course $course
     */
    public function removeCourse(\AppBundle\Entity\Course $course)
    {
        $this->courses->removeElement($course);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Teacher
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
     * Set workExp
     *
     * @param string $workExp
     *
     * @return Teacher
     */
    public function setWorkExp($workExp)
    {
        $this->work_exp = $workExp;

        return $this;
    }

    /**
     * Get workExp
     *
     * @return string
     */
    public function getWorkExp()
    {
        return $this->work_exp;
    }

    /**
     * Set major
     *
     * @param string $major
     *
     * @return Teacher
     */
    public function setMajor($major)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * Get major
     *
     * @return string
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Teacher
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
     * Set valid
     *
     * @param boolean $valid
     *
     * @return Teacher
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }
}
