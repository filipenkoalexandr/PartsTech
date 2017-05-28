<?php


namespace AppBundle\Service;

use AppBundle\Config\PagesConfig;
use AppBundle\Service\Pages\IProductParser;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DomCrawler\Crawler;

class ParserManager
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var PagesConfig
     */
    private $config;

    /**
     * @var string
     */
    private $pageUrl;

    public function __construct(Crawler $crawler, PagesConfig $params)
    {
        $this->crawler = $crawler;
        $this->config = $params;
    }

    /**
     * @param string $pageAlias
     * @throws
     * @return IProductParser
     */
    public function getParser($pageAlias)
    {
        $page = $this->config->findPage($pageAlias);

        if($page === null) {

           throw new Exception("Not found alias parser {$pageAlias}");
        }

        $pageClass = $page->getClassName();
        $this->pageUrl = $page->getUrl();

        return new $pageClass($this->crawler, "https://stylus.ua/{$this->pageUrl}", $page->getConfigurations());
    }

    /**
     * @return string
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

}