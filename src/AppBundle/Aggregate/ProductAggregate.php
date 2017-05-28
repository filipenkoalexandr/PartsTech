<?php


namespace AppBundle\Aggregate;


use AppBundle\Entity\Product;
use AppBundle\Entity\ProductConfiguration;

class ProductAggregate implements IProductAggregate
{

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var ProductConfiguration[]
     */
    protected $configuration = [];


    public function __construct()
    {
        $this->product = new Product();
    }

    /**
     * @param string $url
     * @param string $name
     * @param string|integer $value
     * @return $this
     */
    public function setConfiguration($url, $name, $value)
    {
        $this->configuration[] = (new ProductConfiguration())
            ->setUrl($url)
            ->setName($name)
            ->setValue($value);

        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setProductTitle($title)
    {
        $this->product->setTitle($title);

        return $this;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setProductPrice($price)
    {
        $this->product->setPrice($price);

        return $this;
    }

    /**
     * @param $photo
     * @return $this
     */
    public function setProductPhoto($photo)
    {
        $this->product->setImage($photo);

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return ProductConfiguration[]
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }


}