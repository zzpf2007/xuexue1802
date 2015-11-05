<?php

namespace AppBundle\Utility;

class Category
{
    private $content;

    public function __construct( $content )
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}
