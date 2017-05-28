<?php


namespace AppBundle\Service\Pages;


use AppBundle\Aggregate\IProductAggregate;

interface IProductParser
{
    /**
     * @param \Closure $closure
     * @return IProductAggregate[]
     */
    public function each(\Closure $closure);

    /**
     * @param integer $limit
     * @return void
     */
    public function setLimitPage($limit);

}