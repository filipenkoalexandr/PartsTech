<?php


namespace AppBundle\Service\Pages;


use AppBundle\Aggregate\IProductAggregate;

interface IPages
{
    /**
     * @param \Closure $closure
     * @return IProductAggregate[]
     */
    public function each(\Closure $closure);

}