<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Models;

use Jacoz\Symfony\ApiBundle\Model\Search;

class CustomSearch extends Search
{
    /**
     * @var string
     */
    protected $foo;

    /**
     * @var string
     */
    protected $bar;

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * @param string $foo
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;
    }

    /**
     * @return string
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * @param string $bar
     */
    public function setBar($bar)
    {
        $this->bar = $bar;
    }
}
