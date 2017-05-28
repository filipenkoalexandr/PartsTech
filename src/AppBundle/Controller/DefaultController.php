<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/filterGroup")
     */
    public function filterGroupAction(Request $request)
    {
        $service = $this->get('stylus');
        $filters = $service->getFilterGroupByCategoryUrl('naushniki-i-garnitury');

        return new JsonResponse($filters);

    }

    /**
     * @Route("/product")
     */
    public function productAction(Request $request)
    {
        $service = $this->get('stylus');
        $product = $service->getProductListByUrl('naushniki-i-garnitury');

        return new JsonResponse($product);
    }
}
