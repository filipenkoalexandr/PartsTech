<?php


namespace AppBundle\Aggregate;


use AppBundle\Entity\ClampType;
use AppBundle\Entity\ConnectorType;
use AppBundle\Entity\ConstructionType;
use AppBundle\Entity\DeviceType;
use AppBundle\Entity\Product;

class HeadSetAggregate extends AbstractProductAggregate implements IProductAggregate
{

    /**
     * @var ClampType
     */
    protected $clampType;

    /**
     * @var DeviceType
     */
    protected $deviceType;

    /**
     * @var ConstructionType
     */
    protected $constructionType;

    /**
     * @var Product
     */
    protected $product;


    public function __construct()
    {
        $this->product = new Product();
    }

    /**
     * @param string
     * @return $this
     */
    public function setClampType($clampType)
    {
        $this->clampType = (new ClampType)
            ->setNameRu($clampType)
            ->setType(1);

        return $this;
    }

    /**
     * @param string
     * @return $this
     */
    public function setConstructionType($constructionType)
    {
        $this->constructionType = (new ConstructionType)
            ->setNameRu($constructionType)
            ->setType(1);

        return $this;
    }

    /**
     * @param string
     * @return $this
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = (new DeviceType)
            ->setNameRu($deviceType)
            ->setType(1);

        return $this;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setProductTitle($title)
    {
        $this->product->setTitle($title);
        return $this;
    }

    /**
     * @param $price
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
        $this->product->setPhoto($photo);
        return $this;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return [
            $this->clampType,
            $this->deviceType,
            $this->constructionType
        ];
    }

    /**
     * @param array $types
     * @return Product
     */
    public function getProduct(array $types)
    {
        $this->substitutionTypes($types);

        return $this->product->setTypeClamp($this->clampType)
            ->setTypeConstruction($this->constructionType)
            ->setTypeDevice($this->deviceType);
    }


}