<?php


namespace AppBundle\Service;


use AppBundle\Aggregate\IProductAggregate;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class StylusService
{
    /**
     * @var ParserContainer
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(ParserContainer $container, EntityManager $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
    }

    /**
     * @param string $aliasPage
     */
    public function run($aliasPage)
    {
        $parser = $this->container->getPageParser($aliasPage);

        $parser->each(function (IProductAggregate $aggregate) {
            $entities = $this->saveTypes($aggregate);
            $this->saveProduct($aggregate,$entities);
        });
    }

    /**
     * @param IProductAggregate $aggregate
     * @return array
     */
    private function saveTypes(IProductAggregate $aggregate)
    {
       return array_map(function ($entity) {

            $repository = $this->manager->getRepository(get_class($entity));
            $findEntity = $this->findTypeByName($entity, $repository);

            if (!empty($findEntity)) {
                $entity = $findEntity;
            } else {
                $this->manager->persist($entity);
                $this->manager->flush();
            }

            return $entity;

        }, $aggregate->getTypes());
    }

    /**
     * @param array $entities
     * @param IProductAggregate $aggregate
     */
    private function saveProduct(IProductAggregate $aggregate, array $entities)
    {
        $product = $aggregate->getProduct($entities);
        $this->manager->persist($product);
        $this->manager->flush();
    }

    /**
     * @param object $entity
     * @param EntityRepository $repository
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function findTypeByName($entity, EntityRepository $repository)
    {
        return $repository->createQueryBuilder('type')
            ->where('type.nameRu = :name')
            ->setMaxResults(1)
            ->setParameter('name', $entity->getNameRu())
            ->getQuery()
            ->getOneOrNullResult();
    }


}