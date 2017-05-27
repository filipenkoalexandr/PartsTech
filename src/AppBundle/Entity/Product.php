<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var ConstructionType
     * @ORM\ManyToOne(targetEntity="ConstructionType")
     * @ORM\JoinColumn(name="type_construction", referencedColumnName="id")
     */
    private $typeConstruction;

    /**
     * @var DeviceType
     * @ORM\ManyToOne(targetEntity="DeviceType")
     * @ORM\JoinColumn(name="type_device", referencedColumnName="id")
     */
    private $typeDevice;

    /**
     * @var ClampType
     * @ORM\ManyToOne(targetEntity="ClampType")
     * @ORM\JoinColumn(name="type_clamp", referencedColumnName="id")
     */
    private $typeClamp;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Product
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set typeConstruction
     *
     * @param ConstructionType $typeConstruction
     *
     * @return Product
     */
    public function setTypeConstruction(ConstructionType $typeConstruction)
    {
        $this->typeConstruction = $typeConstruction;

        return $this;
    }

    /**
     * Get typeConstruction
     *
     * @return ConstructionType
     */
    public function getTypeConstruction()
    {
        return $this->typeConstruction;
    }

    /**
     * Set typeDevice
     *
     * @param DeviceType $typeDevice
     *
     * @return Product
     */
    public function setTypeDevice(DeviceType $typeDevice)
    {
        $this->typeDevice = $typeDevice;

        return $this;
    }

    /**
     * Get typeDevice
     *
     * @return DeviceType
     */
    public function getTypeDevice()
    {
        return $this->typeDevice;
    }

    /**
     * Set typeClamp
     *
     * @param ClampType $typeClamp
     *
     * @return Product
     */
    public function setTypeClamp(ClampType $typeClamp)
    {
        $this->typeClamp = $typeClamp;

        return $this;
    }

    /**
     * Get typeClamp
     *
     * @return ClampType
     */
    public function getTypeClamp()
    {
        return $this->typeClamp;
    }
}

