<?php
// src/AppBundle/Entity/Category.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
/**
  * @ORM\Entity
  * @ORM\Table(name="category")
  */
class Category
{

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

  /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
  protected $id;

  /**
    * @ORM\Column(type="integer")
    */
  protected $ablesky_id;

  /**
    * @ORM\Column(type="text")
    */
  protected $raw_json;

  /**
    * @ORM\Column(type="text")
    */
  protected $mobile_json;

  /**
    * @ORM\Column(type="string", length=100)
    */
  protected $md5;

  /**
    * @ORM\Column(type="string", length=10)
    */
  protected $type;

  private $isSave;

  public function __construct() {
    $this->isSave = false;
  }

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
     * Set ableskyId
     *
     * @param integer $ableskyId
     *
     * @return Category
     */
    public function setAbleskyId($ableskyId)
    {
        $this->ablesky_id = $ableskyId;

        return $this;
    }

    /**
     * Get ableskyId
     *
     * @return integer
     */
    public function getAbleskyId()
    {
        return $this->ablesky_id;
    }

    /**
     * Set rawJson
     *
     * @param string $rawJson
     *
     * @return Category
     */
    public function setRawJson($rawJson)
    {
        $this->raw_json = $rawJson;

        return $this;
    }

    /**
     * Get rawJson
     *
     * @return string
     */
    public function getRawJson()
    {
        return $this->raw_json;
    }

    /**
     * Set mobileJson
     *
     * @param string $mobileJson
     *
     * @return Category
     */
    public function setMobileJson($mobileJson)
    {
        $this->mobile_json = $mobileJson;

        return $this;
    }

    /**
     * Get mobileJson
     *
     * @return string
     */
    public function getMobileJson()
    {
        return $this->mobile_json;
    }

    /**
     * Set md5
     *
     * @param string $md5
     *
     * @return Category
     */
    public function setMd5($md5)
    {
        $this->md5 = $md5;

        return $this;
    }

    /**
     * Get md5
     *
     * @return string
     */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Category
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    public function getSave()
    {
        return $this->isSave;
    }
    public function setSave()
    {
        $this->isSave = true;
    }
}
