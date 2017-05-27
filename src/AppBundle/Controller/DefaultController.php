<?php

namespace AppBundle\Controller;

use AppBundle\Aggregate\HeadSetAggregate;
use AppBundle\Aggregate\IProductAggregate;
use AppBundle\Entity\ClampType;
use AppBundle\Service\Pages\HeadSetPage;
use AppBundle\Service\Pages\PagesParams;
use AppBundle\Service\StylusService;
use Doctrine\Common\Persistence\Mapping\Driver\FileLocator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /**
         * @var StylusService $service
         */
        $service = $this->get('stylus');
        $service->run('headset');

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
