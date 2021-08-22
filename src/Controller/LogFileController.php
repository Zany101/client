<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\RemoteService;
use App\Entity\Services;
/**
* @Route("/services/{id}", name="log_file")
*/
class LogFileController extends AbstractController
{
    /**
     * @Route("/logs", name="log_file")
     */
     public function retrieve(Request $request, $id, Services $service ,RemoteService $RemoteService) {
       $sftp = $RemoteService->initialize($service);
       // Should find actual file

       $sftp->chdir($id);

       $file = $service->getGame()->getWebConsole()->getLogFile();
       $output = $sftp->get($file);

       return $this->render('log_file/index.html.twig',
     [
       'results' => $output
     ]);
     }
}
