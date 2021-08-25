<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
use GameQ\GameQ;
use App\Entity\Services;

/**
* @Route("/services/{id}")
*/
class ActivityController extends AbstractController
{
    /**
     * @Route("/activity", name="activity")
     */
    public function index(Request $request, PaginatorInterface $paginator, Services $service): Response
    {


      $GameQ = new \GameQ\GameQ();
      $GameQ->addServer([
          'type' =>  'source',
          'host' => $service->getIpAddress().":".$service->getGamePort(),
      ]);


            $results = $paginator->paginate(
                // Doctrine Query, not results
                $GameQ->process(),
                // Define the page parameter
                $request->query->getInt('page', 1) /*page number*/,
                $request->query->getInt('limit', 10) /*page number*/
            );



        return $this->render('activity/index.html.twig', [
            'results' => $results,
            'host' => $host
        ]);
    }
}
