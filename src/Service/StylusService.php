<?php


namespace App\Service;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductConfiguration;
use App\Service\Pages\HeadSetPage;
use Doctrine\ORM\EntityManagerInterface;

class StylusService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var HeadSetPage
     */
    private $parser;

    public function __construct(EntityManagerInterface $em, HeadSetPage $parser)
    {
        $this->em = $em;
        $this->parser = $parser;
    }

    /**
     * @param string $aliasPage
     */
    public function run($aliasPage)
    {
        if (!$category = $this->em->getRepository(Category::class)->findOneByUrl($aliasPage)) {
            $category = new Category($aliasPage);
            $this->em->persist($category);
        }
        $this->parser->setUrl($aliasPage);
        $this->parser->each(function (Product $product) use ($category) {
            $product->setCategory($category);
            $this->em->persist($product);
            $this->em->flush();
        });
    }
}