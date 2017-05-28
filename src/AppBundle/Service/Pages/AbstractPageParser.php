<?php


namespace AppBundle\Service\Pages;

use AppBundle\Aggregate\IProductAggregate;
use AppBundle\Aggregate\ProductAggregate;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractPageParser implements IProductParser
{
    /**
     * @var Crawler
     */
    protected $parser;

    /**
     * @var integer
     */
    protected $countPage;

    /**
     * @var integer
     */
    protected $limitPage;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $configurations;


    public function __construct(Crawler $crawler, $url, array $configurations)
    {
        $this->parser = $crawler;
        $this->url = $url;
        $this->configurations = $configurations;
        $this->countPage = $this->countPage();
        $this->limitPage = $this->countPage;
    }

    /**
     * @return integer
     */
    protected function countPage()
    {
        return (int)$this->getPage()->filter('nav.navigate ul > li')->last()->text();
    }

    /**
     * @param integer $num
     * @return Crawler
     */
    protected function getPage($num = 1)
    {
        $url = $this->url . '/?p=' . $num;
        $this->parser->clear();
        $this->parser->add(file_get_contents($url));
        $this->parser = $this->parser->filter('#category-products');

        return $this->parser;
    }

    /**
     * @param integer $num
     * @return Crawler
     */
    protected function getProductList($num)
    {
        return $this->getPage($num)->filter('#category-products > ul.product-list li.item');
    }

    public function each(\Closure $closure)
    {
        $items = [];
        for ($i = 1; $i <= $this->limitPage; $i++) {
            $items[] = $this->getProductList($i)->each(function (Crawler $li) use ($closure) {
                return $closure($this->assignment($li));
            });
        }

        return $items;
    }

    /**
     * @param integer $limitPage
     */
    public function setLimitPage($limitPage)
    {
        if ($limitPage < $this->countPage) {
            $this->limitPage = $limitPage;
        }
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
     * @param ProductAggregate $aggregate
     * @param Crawler $node
     */
    abstract protected function getConfigurations(ProductAggregate $aggregate, Crawler $node);

    /**
     * @param Crawler $li
     * @return Crawler|null
     */
    abstract protected function getConfigurationBlock(Crawler $li);

    /**
     * @param Crawler $li
     * @return IProductAggregate
     */
    protected function assignment(Crawler $li)
    {
        $aggregate = new ProductAggregate();

        $aggregate
            ->setProductPhoto(
                $this->getImage($li)
            )
            ->setProductPrice(
                $this->getPrice($li)
            )
            ->setProductTitle(
                $this->getTitle($li)
            );

        if ($node = $this->getConfigurationBlock($li)) {

            $this->getConfigurations($aggregate, $node);
        }

        return $aggregate;
    }
}