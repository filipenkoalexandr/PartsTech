<?php


namespace AppBundle\Service;


use Symfony\Component\DomCrawler\Crawler;

class PaginatorParser
{
    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function parse()
    {
    }

}