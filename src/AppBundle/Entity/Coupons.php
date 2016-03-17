<?php
// src/AppBundle/Entity/Coupons.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Usercoupon;

/**
  * @ORM\Entity()
  * @ORM\Table(name="coupons")
  */
class Coupons
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
    protected $amount;

    /**
    * @ORM\Column(type="string")
    */
    protected $species;

   /**
    * @ORM\Column(type="string")
    */
    protected $minmoney;

   /**
    * @ORM\Column(type="string")
    */
    protected $time;

    /**
     * @ORM\OneToMany(targetEntity="Usercoupon", mappedBy="Coupons", cascade={"persist", "remove"})
     */
    protected $usercoupon;


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
     * Set amount
     *
     * @param string $amount
     *
     * @return Coupons
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set species
     *
     * @param string $species
     *
     * @return Coupons
     */
    public function setSpecies($species)
    {
        $this->species = $species;

        return $this;
    }

    /**
     * Get species
     *
     * @return string
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * Set minmoney
     *
     * @param string $minmoney
     *
     * @return Coupons
     */
    public function setMinmoney($minmoney)
    {
        $this->minmoney = $minmoney;

        return $this;
    }

    /**
     * Get minmoney
     *
     * @return string
     */
    public function getMinmoney()
    {
        return $this->minmoney;
    }

    /**
     * Set time
     *
     * @param string $time
     *
     * @return Coupons
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usercoupon = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add usercoupon
     *
     * @param \AppBundle\Entity\Usercoupon $usercoupon
     *
     * @return Coupons
     */
    public function addUsercoupon(\AppBundle\Entity\Usercoupon $usercoupon)
    {
        $this->usercoupon[] = $usercoupon;

        return $this;
    }

    /**
     * Remove usercoupon
     *
     * @param \AppBundle\Entity\Usercoupon $usercoupon
     */
    public function removeUsercoupon(\AppBundle\Entity\Usercoupon $usercoupon)
    {
        $this->usercoupon->removeElement($usercoupon);
    }

    /**
     * Get usercoupon
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsercoupon()
    {
        return $this->usercoupon;
    }
}
