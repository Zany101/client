<?php
namespace App\Helpers;

use phpseclib3\Net\SFTP;
use phpseclib3\Net\SSH2;
use phpseclib3\File\ANSI;
use App\Repository\ServiceRepository;

use App\Entity\Service;
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


class Filemanager extends AbstractController
{

  public function file_newname($path, $filename, $sftp)
  {
      if ($pos = strrpos($filename, ".")) {
          $name = substr($filename, 0, $pos);
          $ext = substr($filename, $pos);
      } else {
          $name = $filename;
      }

      $newpath = $path . "/" . $filename;
      $newname = $filename;
      $counter = 1;
      while ($sftp->stat($newname)) {
          $newname = $name . " ($counter)" . @$ext;
          $newpath = $path . "/" . $newname;
          $counter++;
      }

      return $newname;
  }

  public function copy_files($src, $dest = null, $sftp)
  {
      // Inside current folder
      $basename = basename($src);
      $file_name = $this->file_newname($dest, $basename,$sftp);

      if ($sftp->is_dir($src)) {
          $sftp->mkdir($dest . "/" . $file_name);

          // Loop Through files inside folder
          foreach ($sftp->nlist($src) as $file) {
              if ($file == "." || $file == "..") {
                  continue;
              }

              if ($sftp->is_dir($src . "/" . $file)) {
                  $this->copy_files(
                      $src . "/" . $file,
                      $dest . "/" . $file_name,
                      $sftp
                  );
              } else {
                  $sftp->put(
                      $dest . "/" . $file_name . "/" . $file,
                      $sftp->get($src)
                  );
              }
          }
      } else {
          $sftp->put($dest . "/" . $file_name, $sftp->get($src));
      }
  }

  public function dir_only($files) {
    // type 2 is dir
    foreach ($files as $key => $value) {
          if ($value['type'] !=2 ) {
            unset($files[$key]);
          }
    }

    return $this->scandirSorted($files);
  }


  public function StrRemoveLastPart($string, $delimiter)
  {
      $lastdelpos = strrpos($string, $delimiter, -2);
      $result = substr($string, 0, $lastdelpos);
      return $result;
  }

  public function scandirSorted($files)
  {

    foreach ($files as $key => $value) {
          if ($key == "." || $key == "..") {
            unset($files[$key]);
              continue;
          }
    }

    return $files;
      // $sortedData = [];
      // foreach ($path as $file) {
      //     // Skip the . and .. folder
      //     if ($file["filename"] == "." || $file["filename"] == "..") {
      //         continue;
      //     }
      //     array_push($sortedData, $file);
      // }
      // return $sortedData;
  }

}
