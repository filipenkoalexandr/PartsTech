<?php


namespace AppBundle\Service;

use AppBundle\Service\Pages\IPages;
use AppBundle\Config\PagesParams;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DomCrawler\Crawler;

class ParserContainer
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var PagesParams
     */
    private $config;

    public function __construct(Crawler $crawler, PagesParams $params)
    {
        $this->crawler = $crawler;
        $this->config = $params;
    }

    /**
     * @param string $pageAlias
     * @throws
     * @return IPages
     */
    public function getPageParser($pageAlias)
    {
        $page = $this->config->findPage($pageAlias);

        if($page === null) {
           throw new Exception('');
        }

        $pageClass = $page->getClassName();
        $contentProduct = $this->getContent($page->getUrl());

        return new $pageClass($contentProduct);
    }

    /**
     * @param string $url
     * @return Crawler
     */
    private function getContent($url)
    {
        $this->crawler->add(file_get_contents("https://stylus.ua/{$url}"));
        $content = $this->crawler->filter('#category-products > ul.product-list li.item');

        return $content;
    }

}