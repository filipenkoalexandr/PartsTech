<?php


namespace AppBundle\Aggregate;

use AppBundle\Entity\Product;
use AppBundle\Entity\ProductConfiguration;

interface IProductAggregate
{
    /**
     * @return ProductConfiguration[]
     */
    public function getConfiguration();

    /**
     * @return Product
     */
    public function getProduct();
}