<?php


namespace AppBundle\Service\Pages;

use AppBundle\Aggregate\HeadSetAggregate;
use AppBundle\Aggregate\IProductAggregate;
use Symfony\Component\DomCrawler\Crawler;

class HeadSetPage extends AbstractPageParser
{

    /**
     * @param Crawler $li
     * @return IProductAggregate
     */
    protected function assignment(Crawler $li)
    {
        $aggregate = new HeadSetAggregate();

        $span = $li->filter('div.block > div.layout > .right > .list span');

        $aggregate
            ->setConstructionType(
                $this->getTypeConstruction($span)
            )
            ->setDeviceType(
                $this->getTypeDevice($span)
            )
            ->setClampType(
                $this->getTypeClamp($span)
            )
            ->setProductPhoto(
                $this->getPhoto($li)
            )
            ->setProductPrice(
                $this->getPrice($li)
            )
            ->setProductTitle(
                $this->getTitle($li)
            );

        return $aggregate;
    }

    protected function getTypeConstruction(Crawler $node)
    {
        return ($node->eq(0)->count()) ? $node->eq(0)->text() : null;
    }

    protected function getTypeDevice(Crawler $node)
    {
        return ($node->eq(1)->count()) ? $node->eq(1)->text() : null;
    }

    protected function getTypeClamp(Crawler $node)
    {
        return ($node->eq(2)->count()) ? $node->eq(2)->text() : null;
    }
}