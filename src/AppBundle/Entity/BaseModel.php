<?php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

abstract class BaseModel
{
  /**
    * Hook timestampable behavior
    * updates createdAt, updatedAt fields
    */
  use TimestampableEntity;

  protected $id;

  /**
    * @ORM\Column(type="integer", nullable=false)
    */
  protected $ablesky_id;

  /**
    * @ORM\Column(type="text", nullable=true)
    */
  protected $raw_json;

  /**
    * @ORM\Column(type="text", nullable=true)
    */
  protected $mobile_json;

  /**
    * @ORM\Column(type="string", length=100, nullable=true)
    */
  protected $md5;

  public function __construct() {
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
}
