<?php
// src/AppBundle/Entity/usercoupon.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;
use AppBundle\Entity\Coupons;

/**
  * @ORM\Entity()
  * @ORM\Table(name="user_coupon")
  */
class Usercoupon
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="usercoupon")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $user; 

    /**
     * @ORM\ManyToOne(targetEntity="Coupons", inversedBy="usercoupon")
     * @ORM\JoinColumn(name="coupons_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $coupons; 

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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Usercoupon
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

    /**
     * Set coupons
     *
     * @param \AppBundle\Entity\Coupons $coupons
     *
     * @return Usercoupon
     */
    public function setCoupons(\AppBundle\Entity\Coupons $coupons = null)
    {
        $this->coupons = $coupons;

        return $this;
    }

    /**
     * Get coupons
     *
     * @return \AppBundle\Entity\Coupons
     */
    public function getCoupons()
    {
        return $this->coupons;
    }
}
