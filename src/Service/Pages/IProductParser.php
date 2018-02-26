<?php


namespace App\Service\Pages;



interface IProductParser
{
    /**
     * @param \Closure $closure
     */
    public function each(\Closure $closure);
}