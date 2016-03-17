<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Account;
use AppBundle\Entity\Coin;
use AppBundle\Entity\Camerauser;
use AppBundle\Entity\Usercoupon;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              nullable = true,
 *              unique= false
 *          )
 *      ),
 *     @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name = "email_canonical",
 *              nullable = true,
 *              unique= false
 *          )
 *      )
 * })
 */


class User extends BaseUser
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

  
    public function __construct()
    {
        parent::__construct();
        // $account = new Account();
        // $coin = new Coin();

        // $this->setAccount( $account );
        // $this->setCoin( $coin );
        // your own logic
    }

   /**
    * @ORM\Column(type="string", length=20)
    */
    protected $mobile = '';


    /**
     * @ORM\OneToOne(targetEntity="Account", mappedBy="user")
     */
    protected $account;


     /**
     * @ORM\OneToOne(targetEntity="Coin", mappedBy="user")
     */
    protected $coin;

    /**
     * @ORM\OneToOne(targetEntity="Camerauser", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $camerauser;

    /**
     * @ORM\OneToMany(targetEntity="Usercoupon", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $usercoupon;

    /**
     * Set mobile
     *
     * @param integer $mobile
     *
     * @return Category
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return integer
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set account
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return User
     */
    public function setAccount(\AppBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \AppBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set coin
     *
     * @param \AppBundle\Entity\Coin $coin
     *
     * @return User
     */
    public function setCoin(\AppBundle\Entity\Coin $coin = null)
    {
        $this->coin = $coin;

        return $this;
    }

    /**
     * Get coin
     *
     * @return \AppBundle\Entity\Coin
     */
    public function getCoin()
    {
        return $this->coin;
    }

  

    /**
     * Add camerauser
     *
     * @param \AppBundle\Entity\Camerauser $camerauser
     *
     * @return User
     */
    public function addCamerauser(\AppBundle\Entity\Camerauser $camerauser)
    {
        $this->camerauser[] = $camerauser;

        return $this;
    }

    /**
     * Remove camerauser
     *
     * @param \AppBundle\Entity\Camerauser $camerauser
     */
    public function removeCamerauser(\AppBundle\Entity\Camerauser $camerauser)
    {
        $this->camerauser->removeElement($camerauser);
    }

    /**
     * Get camerauser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCamerauser()
    {
        return $this->camerauser;
    }

    /**
     * Set camerauser
     *
     * @param \AppBundle\Entity\Camerauser $camerauser
     *
     * @return User
     */
    public function setCamerauser(\AppBundle\Entity\Camerauser $camerauser = null)
    {
        $this->camerauser = $camerauser;

        return $this;
    }

  
  

    /**
     * Add course
     *
     * @param \AppBundle\Entity\Course $course
     *
     * @return User
     */
    public function addCourse(\AppBundle\Entity\Course $course)
    {
        $this->course[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \AppBundle\Entity\Course $course
     */
    public function removeCourse(\AppBundle\Entity\Course $course)
    {
        $this->course->removeElement($course);
    }

    /**
     * Get course
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourse()
    {
        return $this->course;
    }


    /**
     * Add usercoupon
     *
     * @param \AppBundle\Entity\Usercoupon $usercoupon
     *
     * @return User
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
