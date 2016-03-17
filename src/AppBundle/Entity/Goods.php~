<?php
// src/AppBundle/Entity/Goods.php
namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
  * @ORM\Entity()
  * @ORM\Table(name="goods")
  */
class Goods
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
    protected $goodsname;

   /**
    * @ORM\Column(type="integer")
    */
    protected $goodsnumber;

   /**
    * @ORM\Column(type="integer")
    */
    protected $soldnumber;

   /**
    * @ORM\Column(type="string")
    */
    protected $goodsprice;

   /**
    * @ORM\Column(type="string")
    */
    protected $goodsphoto;

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
     * Set goodsname
     *
     * @param string $goodsname
     *
     * @return Goods
     */
    public function setGoodsname($goodsname)
    {
        $this->goodsname = $goodsname;

        return $this;
    }

    /**
     * Get goodsname
     *
     * @return string
     */
    public function getGoodsname()
    {
        return $this->goodsname;
    }

    /**
     * Set goodsnumber
     *
     * @param integer $goodsnumber
     *
     * @return Goods
     */
    public function setGoodsnumber($goodsnumber)
    {
        $this->goodsnumber = $goodsnumber;

        return $this;
    }

    /**
     * Get goodsnumber
     *
     * @return integer
     */
    public function getGoodsnumber()
    {
        return $this->goodsnumber;
    }

    /**
     * Set soldnumber
     *
     * @param integer $soldnumber
     *
     * @return Goods
     */
    public function setSoldnumber($soldnumber)
    {
        $this->soldnumber = $soldnumber;

        return $this;
    }

    /**
     * Get soldnumber
     *
     * @return integer
     */
    public function getSoldnumber()
    {
        return $this->soldnumber;
    }

    /**
     * Set goodsprice
     *
     * @param string $goodsprice
     *
     * @return Goods
     */
    public function setGoodsprice($goodsprice)
    {
        $this->goodsprice = $goodsprice;

        return $this;
    }

    /**
     * Get goodsprice
     *
     * @return string
     */
    public function getGoodsprice()
    {
        return $this->goodsprice;
    }

    /**
     * Set goodsphoto
     *
     * @param string $goodsphoto
     *
     * @return Goods
     */
    public function setGoodsphoto($goodsphoto)
    {
        $this->goodsphoto = $goodsphoto;

        return $this;
    }

    /**
     * Get goodsphoto
     *
     * @return string
     */
    public function getGoodsphoto()
    {
        return $this->goodsphoto;
    }

}
