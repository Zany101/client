<?php
namespace App\Service;

use phpseclib3\Net\SFTP;
use phpseclib3\Net\SSH2;
use phpseclib3\File\ANSI;
use App\Repository\ServiceRepository;

use App\Entity\Services;
use App\Entity\User;
use App\Entity\GameServices;
use App\Entity\Game;
use App\Entity\GamePorts;
use App\Form\ConfigServicesFormType;
use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class RemoteService extends AbstractController
{

  public function initialize(Services $services)
  {
      $sftp = new SFTP($services->getServer()->getPrimaryIp());
      $sftp->login($services->getServer()->getMonitorLogin(), $services->getServer()->getMonitorPassword()) or die("coulnt connect");
      $sftp->setListOrder(
          true,
          "size",
          SORT_DESC,
          "filename",
          SORT_ASC,
          "filetype",
          SORT_DESC
      );


      return $sftp;
  }

}
