<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
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
     * @var int
     *
     * @ORM\Column(name="stylus_id", nullable=true, type="integer")
     */
    private $stylusId;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="price", nullable=true, type="integer")
     */
    private $price;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ProductConfiguration", mappedBy="product")
     */
    protected $configurations;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var Category
     *
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;

    /**
     * Product constructor.
     * @param int $stylusId
     * @param string $image
     * @param int $price
     * @param string $title
     */
    public function __construct($stylusId, $image, $price, $title)
    {
        $this->stylusId = $stylusId;
        $this->image = $image;
        $this->price = $price;
        $this->title = $title;
    }


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
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param ProductConfiguration $config
     */
    public function setConfigurations($config)
    {
        $this->configurations = $config;
    }

    /**
     * @param ProductConfiguration $config
     */
    public function addConfigurations($config)
    {
        $this->configurations[] = $config;
    }

    /**
     * @return ProductConfiguration[]
     */
    public function getConfigurations()
    {
        return $this->configurations->toArray();
    }

    /**
     * @return int
     */
    public function getStylusId(): int
    {
        return $this->stylusId;
    }

    /**
     * @param int $stylusId
     *
     * @return Product
     */
    public function setStylusId(int $stylusId)
    {
        $this->stylusId = $stylusId;

        return $this;
    }
}

