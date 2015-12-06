<?php

namespace Acme\Bundle\MySysBundle\Entity;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $pid;

    /**
     * @var integer
     */
    private $corder;


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
     * @return Category
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
     * Set pid
     *
     * @param string $pid
     *
     * @return Category
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return string
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set corder
     *
     * @param integer $corder
     *
     * @return Category
     */
    public function setCorder($corder)
    {
        $this->corder = $corder;

        return $this;
    }

    /**
     * Get corder
     *
     * @return integer
     */
    public function getCorder()
    {
        return $this->corder;
    }
}

