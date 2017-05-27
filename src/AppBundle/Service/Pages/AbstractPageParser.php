<?php


namespace AppBundle\Service\Pages;

use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractPageParser implements IPages
{
    /**
     * @var Crawler
     */
    protected $parser;

    /**
     * @var array
     */
    protected $collection;

    public function __construct(Crawler $crawler)
    {
        $this->parser = $crawler;
    }

    protected function getTitle(Crawler $li)
    {
        return $li->filter('div.block > .item-title a')->text();
    }

    protected function getPrice(Crawler $li)
    {
        return $li->filter('div.block > div.layout > div.left > span.price > span')->text();
    }

    protected function getPhoto(Crawler $li)
    {
        $src = $li->filter('a.frame img')->attr('src');
        if (!$src) {
            $src = $li->filter('a.frame img')->attr('data-original');
        }

        return $src;
    }

    protected function countPage()
    {
        return $this->parser->filter('nav.navigate ul > li')->count();
    }

    public function each(\Closure $closure)
    {
        return $this->parser->each(function (Crawler $li) use ($closure) {
            return $closure($this->assignment($li));
        });
    }

    abstract protected function assignment(Crawler $node);
}