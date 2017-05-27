<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClampType
 *
 * @ORM\Table(name="clamp_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClampTypeRepository")
 */
class ClampType
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
     * @ORM\Column(name="name_ru", type="string", length=255)
     */
    private $nameRu;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;


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
     * Set nameRu
     *
     * @param string $nameRu
     *
     * @return ClampType
     */
    public function setNameRu($nameRu)
    {
        $this->nameRu = $nameRu;

        return $this;
    }

    /**
     * Get nameRu
     *
     * @return string
     */
    public function getNameRu()
    {
        return $this->nameRu;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return ClampType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}

