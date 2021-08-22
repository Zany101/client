<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\ConfigServicesFormType;
use App\Entity\Services;
use App\Entity\Games;
use App\Service\PortService;
use phpseclib3\Net\SFTP;
use phpseclib3\Net\SSH2;
use phpseclib3\File\ANSI;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\RemoteService;

class ServicesController extends AbstractController
{

  private $ip = '192.168.192.10';
  private $user = 'frontliner';
  private $password = 'Hardstyle18';
  private $base = "/home/frontliner/Steam/steamapps/common/chivalry_ded_server/";
  private $place = null;


  /**
   * @Route("services/{id}/status")
   */
  public function status(Request $request, $id, Services $service,RemoteService $RemoteService) {
    $ssh = $RemoteService->initialize($service);


        if($service->getPid() == null) {
          return new Response('offline');

        }
        $pid = $service->getPid();
        $mem  = $ssh->exec("ps -p {$pid} -o %mem");
        $cpu =$ssh->exec("ps -p {$pid} -o %cpu");

        $results = [
          "mem" => $ssh->exec("ps -p {$pid} -o %mem"),
          'cpu' => $ssh->exec("ps -p {$pid} -o %cpu")
        ];

        return new JsonResponse("online");

  }

  /**
   * @Route("services/{id}/start")
   */
  public function start(Request $request, $id, Services $service,RemoteService $RemoteService) {
    $ssh = $RemoteService->initialize($service);
        //
        // $results = [
        //   "mem" => $ssh->exec("ps -p {$pid} -o %mem"),
        //   'cpu' => $ssh->exec("ps -p {$pid} -o %cpu"),
        //   'pid' => '',
        //   'status' => ''
        // ];


        if($service->getPid() == null) {
          $pid = $ssh->exec("nohup {$id}/".$service->getExecutable()." ".$service->getCmdline()." & echo $!;");

          $service->setPid((int)$pid);
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();

          return new Response("started with PID ".(int)$pid);

        }

        return new Response("running with PID ".$service->getPid());

  }

  /**
   * @Route("services/{id}/stop")
   */
  public function stop(Request $request, $id, Services $service,RemoteService $RemoteService) {

    if($service->getPid() != null) {
      $ssh = $RemoteService->initialize($service);
      // $ssh->write("cd {$id}\n");
      $pid = $service->getPid();
      $ssh->exec("kill ".$service->getPid().";");

      $service->setPid(null);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->flush();

      return new Response('Procees of PID '.$pid."Has been terminated.");

    }
    return new Response("No proccess found");

  }

  /**
   * @Route("services/{id}/restart")
   */
  public function restart(Request $request, $id, Services $service,RemoteService $RemoteService) {
      // Requires tokens to validate user

      if($service->getPid() != null) {

        $this->close($request, $id,  $service, $RemoteService);
        $this->start($request, $id,  $service, $RemoteService);

        return new Response("started with PID ".(int)$pid);

      }

      return new Response("running with PID ".$service->getPid());

  }

      /**
       * @Route("services/create")
       */
      public function create(Request $request, PortService $PortService, RemoteService $RemoteService) : Response {

          $form = $this->createForm(ConfigServicesFormType::class);

          // dump($this->avaible_ports($game));

          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {

              $service = $form->getData();

              $ssh = $RemoteService->initialize($service);


              $avaiblePorts = $PortService->avaible_ports(
                  $service
                      ->getGame()
                      ->getId()
              );

              $game = $service->getGame();

              $service->setWorkingDir(
                  $game->getPaths()->getFilesFolderName()
              );
              $service->setExecutable(
                  $game->getPaths()->getRelativeExecutable()
              );


              $game->getCmdlines()->getCmdlineDefault();



              $service->setCmdline(
                $game->getCmdlines()->getCmdlineDefault()
              );
              $service->setDisplayName($game->getDisplayName());

              $service->setGamePort($avaiblePorts['gamePort']);
              $service->setQueryPort($avaiblePorts['queryPort']);
              $service->setRconPort($avaiblePorts['queryPort']);

              $service->setCustomPort1($avaiblePorts['customPort1']);
              $service->setCustomPort2($avaiblePorts['customPort2']);
              $service->setCustomPort3($avaiblePorts['customPort3']);
              $service->setCustomPort4($avaiblePorts['customPort4']);
              $service->setCustomPort5($avaiblePorts['customPort5']);
              $service->setCustomPort6($avaiblePorts['customPort6']);

              $service->setIpAddress($service->getServer()->getPrimaryIp());
              // Installing service? Should have controler???
              $game = $service->getGame();

              $steamid = $game->getSteamConfig()->getHldsGameType();
              $steamAccount = $game->getSteamConfig()->getSteamAccount();
              $steamPassword = $game->getSteamConfig()->getSteamPassword();

              $search = [
                '$[Service.IpAddress]',
                '$[Service.GamePort]',
                '$[Service.QueryPort]',
                '$[Service.Slots]',
                '[svsetsteamaccount]'

              ];
              $replace = [
                $service->getServer()->getPrimaryIp(),
                $service->getGamePort(),
                $service->getQueryPort(),
                $service->getSlots(),
                null
              ];

              // foreach ($arr as $key => $value) {
                $cmd = str_replace($search, $replace, $game->getCmdlines()->getCmdlineDefault());
              // }
              $service->setCmdline($cmd);

              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($service);
              $entityManager->flush();
              // echo $service->getId();
              // exit;
              if ($steamAccount == null) $steamAccount = "anonymous";

              // echo" steamcmd +login ".$steamAccount ." " .$steamPassword ." +force_install_dir /home/frontliner/".$service->getId()."/ +app_update " . $steamid . " +quit > /dev/null 2>&1 &";
              // Instal desired service (steamCmd);
              $log = $ssh->exec('steamcmd +login '.$steamAccount .' ' .$steamPassword .' +force_install_dir /home/frontliner/'.$service->getServiceId().'/ +app_update ' . $steamid . ' +quit >logs/output-'.$service->getServiceId().'.log 2>&1 &');

              return $this->redirectToRoute('services');
          }

          return $this->render('services/create.html.twig', [
              'form' => $form->createView()
          ]);

      }
      /**
       * @Route("services/{id}/delete")
       */
      public function delete(Services $service, Request $request, $id, RemoteService $RemoteService) : Response {

        $user = $this->getUser();

        if ($service->getUser()->getId() != $user->getId()) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $sftp = $RemoteService->initialize($service);

        if (!$service) {
             throw $this->createNotFoundException();
         }

           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->remove($service);
           $entityManager->flush();
           $sftp->delete($id);

        return $this->redirectToRoute('services');

      }
    /**
     * @Route("/services", name="services")
     * @Route("/")
     */
     public function list(Request $request, PaginatorInterface $paginator) : Response {

       $user = $this->getUser();

         $em = $this->getDoctrine()->getManager();
         $servicesRepository = $em->getRepository(Services::class);
         $allServicesQuery = $servicesRepository
             ->createQueryBuilder('s')
             ->where('s.userId = :uid' )
             ->setParameter('uid',  $user->getId())
             ->getQuery();

         $services = $paginator->paginate(
             // Doctrine Query, not results
             $allServicesQuery,
             // Define the page parameter
             $request->query->getInt('page', 1) /*page number*/,
             $request->query->getInt('limit', 10) /*page number*/
         );

         $games = $this->getDoctrine()
             ->getRepository(Games::class)
             ->find(139);

         return $this->render('services/index.html.twig', [
             'results' => $services,
             'games' => $games,
             'navItems' => [
               'Game Services' => [
                 'url' => 'services'
               ],
               'Voice Services' => [
                 'url' => 'services'
               ],
               'New Service' => [
                 'url' => 'services/create'
               ]
             ]

         ]);
     }

     /**
      * @Route("/services/{id}")
      */
     public function item($id, Services $service)
     {

        $user = $this->getUser();

        if ($service->getUser()->getId() != $user->getId()) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
         //
         // $services = $this->getDoctrine()
         //     ->getRepository(Services::class)
         //     ->findOneBy([
         //       'serviceId' => $id,
         //       'userId' => $user->getId()
         //     ]);

         if ($service->getUser()->getId() != $user->getId()) {
             throw $this->createNotFoundException(
                 'No product found for id ' . $id
             );
         }



         return $this->render('services/item.html.twig', [
             'services' => $service,
         ]);
     }
}
