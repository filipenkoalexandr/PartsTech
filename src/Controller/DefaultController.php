<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductConfiguration;;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() : Response
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/filterGroup")
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function filterGroupAction(EntityManagerInterface $em) : JsonResponse
    {
        return new JsonResponse(
            $em->getRepository(ProductConfiguration::class)->findByCategoryUrl('iphone-170')
        );
    }

    /**
     * @Route("/product")
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function productAction(EntityManagerInterface $em) : JsonResponse
    {
        return new JsonResponse(
            $em->getRepository(Product::class)->findByCategoryUrl('iphone-170')
        );
    }
}
