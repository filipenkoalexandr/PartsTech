<?php


namespace AppBundle\Service;

use AppBundle\Aggregate\IProductAggregate;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductConfiguration;
use AppBundle\Repository\CategoryRepository;
use AppBundle\Repository\ProductConfigurationRepository;
use AppBundle\Repository\ProductRepository;

class StylusService
{
    /**
     * @var ParserManager
     */
    private $parserManager;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductConfiguration
     */
    private $configurationRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        ParserManager $parserManager,
        ProductConfigurationRepository $configurationRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->parserManager = $parserManager;
        $this->productRepository = $productRepository;
        $this->configurationRepository = $configurationRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param string $aliasPage
     */
    public function run($aliasPage)
    {
        $parser = $this->parserManager->getParser($aliasPage);
        $category = $this->getCategory(
            $this->parserManager->getPageUrl()
        );

        $parser->each(function (IProductAggregate $aggregate) use ($category) {

            $this->saveProduct($aggregate, $category);

        });
    }

    /**
     * @param $pageUrl
     * @return Category|null|object
     */
    private function getCategory($pageUrl)
    {
        $category = $this->categoryRepository->findByUrl($pageUrl);

        if ($category === null) {
            $category = new Category();
            $category->setUrl($pageUrl);
            $this->categoryRepository->save($category);
        }

        return $category;
    }

    /**
     * @param IProductAggregate $aggregate
     * @param $category
     */
    private function saveProduct(IProductAggregate $aggregate, Category $category)
    {
        $product = $aggregate->getProduct();
        $product->setCategoryId($category->getId());
        $product = $this->productRepository->save($product);

        array_map(function (ProductConfiguration $config) use ($product) {

            if($config->getValue() !== null) {

                $config->setProduct($product);
                $this->assignConfigId($config);

                $this->configurationRepository->save($config);
            }

        }, $aggregate->getConfiguration());
    }

    /**
     * @param ProductConfiguration $config
     */
    private function assignConfigId(ProductConfiguration $config)
    {
        $id = $this->configurationRepository->getExistingId($config);

        if (empty($id)) {
            $id = random_int(100, 9999);
        }

        $config->setConfigId($id);
    }

    /**
     * @param string $url
     * @return Product[]
     */
    public function getProductListByUrl($url)
    {
        return $this->productRepository->findByCategoryUrl($url);
    }

    /**
     * @param string $url
     * @return array
     */
    public function getFilterGroupByCategoryUrl($url)
    {
        return $this->configurationRepository->findByCategoryUrl($url);
    }


}