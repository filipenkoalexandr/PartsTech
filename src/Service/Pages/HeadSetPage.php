<?php


namespace App\Service\Pages;

use App\Entity\Product;
use App\Entity\ProductConfiguration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

class HeadSetPage extends AbstractPageParser
{

    const BASE_URL = 'https://stylus.ua/';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    protected $url;

    public function __construct(Crawler $crawler, EntityManagerInterface $em)
    {
        parent::__construct($crawler);
        $this->em = $em;
    }

    /**
     * @param $alias
     */
    public function setUrl($alias)
    {
        $this->url = self::BASE_URL . $alias;
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

    /**
     * @param Crawler $li
     * @return null|Crawler
     */
    protected function getConfigurationBlock(Crawler $li)
    {
        $configurationBlock = $li->filter('div.block > div.layout > .right > .list');

        return $configurationBlock->count() ? $configurationBlock : null;
    }

    /**
     * @param Crawler $li
     * @return string
     */
    protected function getTitle(Crawler $li)
    {
        return $li->filter('div.block > .item-title a')->text();
    }

    /**
     * @param Crawler $li
     * @return null|integer
     */
    protected function getPrice(Crawler $li)
    {
        $priceBlock = $li->filter('div.block > div.layout > div.left > span.price > span');

        return $priceBlock->count() ? preg_replace("/[^\d]+/", "", $priceBlock->text()) : null;
    }

    /**
     * @param Crawler $li
     * @return null|string
     */
    protected function getImage(Crawler $li)
    {
        $src = $li->filter('.product-link img')->attr('src');
        if (!$src) {
            $src = $li->filter('.lazy')->attr('data-original');
        }

        return $src;
    }

    /**
     * @param Crawler $li
     * @return mixed
     */
    protected function getStylusId(Crawler $li)
    {
        return preg_replace('/[^0-9]/', '', $li->filter('div.block > div.item-title > .code')->text());
    }


    /**
     * @param Product $product
     * @param Crawler $node
     */
    protected function getConfigurations(Product $product, Crawler $node)
    {
        $htmlConfigurationsList = str_replace('<div class="slide">', '', $node->html());

        $items = explode('<br>', $htmlConfigurationsList);

        foreach ($items as $item) {
            $pieces = explode(':', $item);
            if(!isset($pieces[1])) {
                continue;
            }
            preg_match("/<span ?.*>(.*)<\/span>/", $pieces[1], $val);
            $url = transliterator_transliterate(
                'Any-Latin; Latin-ASCII; Lower()', preg_replace('/\s+/', '-', $pieces[0])
            );
            $configuration = new ProductConfiguration($product, $pieces[0], $val[1], $url);
            $this->em->persist($configuration);
            $product->addConfigurations($configuration);
        }
    }

    /**
     * @param \Closure $closure
     * @return array
     */
    public function each(\Closure $closure)
    {
        $items = [];
        for ($i = 1; $i <= $this->countPage(); $i++) {
            $items[] = $this->getProductList($i)->each(function (Crawler $li) use ($closure) {
                $test = $this->assignment($li);
                return $closure($test);
            });
        }
        return $items;
    }

    /**
     * @param Crawler $li
     * @return Product
     */
    protected function assignment(Crawler $li)
    {
        $product = $this->em->getRepository(Product::class)->findOneByStylusId($this->getStylusId($li));
        if (!$product) {
            $product = new Product(
                $this->getStylusId($li),
                $this->getImage($li),
                $this->getPrice($li),
                $this->getTitle($li)
            );
        }
        $product
            ->setImage(
                $this->getImage($li)
            )
            ->setPrice(
                $this->getPrice($li)
            )
            ->setTitle(
                $this->getTitle($li)
            )
            ->setStylusId(
                $this->getStylusId($li)
            );

        if ($node = $this->getConfigurationBlock($li)) {
            $this->getConfigurations($product, $node);
        }

        return $product;
    }
}