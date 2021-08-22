<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Services;
use App\Entity\GameConfigFiles;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\RemoteService;
/**
* @Route("/services/{id}", name="config_files")
*/
class ConfigFilesController extends AbstractController
{
    /**
     * @Route("/config")
     */
    public function index(Request $request, $id, PaginatorInterface $paginator, Services $service): Response
    {

        dump($service->getGame()->getConfigFiles());
          $services = $paginator->paginate(
              $service->getGame()->getConfigFiles(), /* query NOT result */
              $request->query->getInt('page', 1), /*page number*/
              $request->query->getInt('limit', 10), /*page number*/
          );

          return $this->render('config_files/index.html.twig',
        [
          'results' => $services
        ]);

    }
    /**
     * @Route("/config/edit/{item}")
     */
    public function retrieve(Request $request, $id, Services $service, $item,RemoteService $RemoteService) {
      $sftp = $RemoteService->initialize($service);
      // Should find actual file

      $sftp->chdir($id);

      $file = $service->getGame()->getConfigFiles()[0]->getRelativePath();
      $output = $sftp->get($file);

      return new Response($output);
    }
}
