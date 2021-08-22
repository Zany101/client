<?php
namespace App\Service;

use phpseclib3\Net\SFTP;
use phpseclib3\Net\SSH2;
use phpseclib3\File\ANSI;
use App\Repository\ServiceRepository;

use App\Entity\Services;
use App\Entity\User;
use App\Entity\Game;
use App\Entity\GamePorts;
use App\Form\ConfigServicesFormType;
use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class PortService extends AbstractController
{

  public function avaible_ports($gameId)
  {
      // Should return object so all can be handled in 1 single swoop
      // Also should be more specific diffrent servers can share same ports without port conflicts
      // GamePorts
      $ports = $this->getDoctrine()
          ->getRepository(GamePorts::class)
          ->find($gameId);
      $services = $this->getDoctrine()
          ->getRepository(Services::class)
          ->findBy(['gameId' => $gameId]);
      // $port = $service->getGamePorts();
      $port = [
          'gamePort' => $ports->getGamePort(),
          'queryPort' => $ports->getQueryPort(),
          'customPort1' => $ports->getCustomPort1(),
          'customPort2' => $ports->getCustomPort2(),
          'customPort3' => $ports->getCustomPort3(),
          'customPort4' => $ports->getCustomPort4(),
          'customPort5' => $ports->getCustomPort5(),
          'customPort6' => $ports->getCustomPort6()
      ];

      $increment = $ports->getPortIncrement();

      for ($i = 0; $i < count($services); $i++) {
          if (
              $port['gamePort']    != $services[$i]->getGamePort() &&
              $port['queryPort']   != $services[$i]->getQueryPort() &&
              $port['customPort1'] != $services[$i]->getCustomPort1() &&
              $port['customPort2'] != $services[$i]->getCustomPort2() &&
              $port['customPort3'] != $services[$i]->getCustomPort3() &&
              $port['customPort4'] != $services[$i]->getCustomPort4() &&
              $port['customPort5'] != $services[$i]->getCustomPort5() &&
              $port['customPort6'] != $services[$i]->getCustomPort6()
          ) {
              break;
          }

          if ($port['gamePort']    == $services[$i]->getGamePort()) $port['gamePort'] += $increment;
          if ($port['queryPort']   == $services[$i]->getQueryPort()) $port['queryPort'] += $increment;
          if ($port['customPort1'] == $services[$i]->getCustomPort1()) $port['customPort1'] += $increment;
          if ($port['customPort2'] == $services[$i]->getCustomPort2()) $port['customPort2'] += $increment;
          if ($port['customPort3'] == $services[$i]->getCustomPort3()) $port['customPort3'] += $increment;
          if ($port['customPort4'] == $services[$i]->getCustomPort4()) $port['customPort4'] += $increment;
          if ($port['customPort5'] == $services[$i]->getCustomPort5()) $port['customPort5'] += $increment;
          if ($port['customPort6'] == $services[$i]->getCustomPort6()) $port['customPort6'] += $increment;

      }

      $ports->setGamePort($port['gamePort']);
      $ports->setQueryPort($port['queryPort']);
      $ports->setCustomPort1($port['customPort1']);
      $ports->setCustomPort2($port['customPort2']);
      $ports->setCustomPort3($port['customPort3']);
      $ports->setCustomPort4($port['customPort4']);
      $ports->setCustomPort5($port['customPort5']);
      $ports->setCustomPort6($port['customPort6']);

      return $port;
  }

}
