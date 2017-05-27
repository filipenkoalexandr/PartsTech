<?php


namespace AppBundle\Aggregate;

interface IProductAggregate
{
    /**
     * @return array
     */
    public function getTypes();

    /**
     * @param array $entityTypes
     * @return object
     */
    public function getProduct(array $entityTypes);
}