<?php


namespace AppBundle\Service\Pages;

use AppBundle\Aggregate\ProductAggregate;
use Symfony\Component\DomCrawler\Crawler;

class HeadSetPage extends AbstractPageParser
{

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
     * @param ProductAggregate $aggregate
     * @param Crawler $node
     */
    protected function getConfigurations(ProductAggregate $aggregate, Crawler $node)
    {
        $htmlConfigurationsList = $node->html();

        $items = explode('<br>', $htmlConfigurationsList);

        foreach ($this->configurations as $url => $confName) {
            foreach ($items as $item) {

                if (stristr($item, $confName)) {

                    preg_match("/<span ?.*>(.*)<\/span>/", $item, $val);
                    $aggregate->setConfiguration($url, $confName, $val[1]);
                }
            }
        }
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
        $src = $li->filter('a.frame img')->attr('src');
        if (!$src) {
            $src = $li->filter('a.frame img')->attr('data-original');
        }

        return $src;
    }
}