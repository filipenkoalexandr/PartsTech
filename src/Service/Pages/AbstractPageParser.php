<?php


namespace App\Service\Pages;

use App\Entity\Product;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractPageParser implements IProductParser
{
    /**
     * @var Crawler
     */
    protected $parser;

    public function __construct(Crawler $crawler)
    {
        $this->parser = $crawler;
    }

    /**
     * @param Crawler $li
     * @return string
     */
    abstract protected function getTitle(Crawler $li);

    /**
     * @param Crawler $li
     * @return integer|null
     */
    abstract protected function getPrice(Crawler $li);

    /**
     * @param Crawler $li
     * @return string|null
     */
    abstract protected function getImage(Crawler $li);

    /**
     * @param Product $product
     * @param Crawler $node
     */
    abstract protected function getConfigurations(Product $product, Crawler $node);

    /**
     * @param Crawler $li
     * @return Crawler|null
     */
    abstract protected function getConfigurationBlock(Crawler $li);

}