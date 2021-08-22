<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use phpseclib3\Net\SFTP;

use App\Entity\Services;

use App\Helpers\Filemanager;
use App\Service\RemoteService;
/**
 * @Route("/services/{id}/filemanager", requirements={"id"=".+"})
 */

class FilemanagerController extends AbstractController
{

    private $base;
    private $place = null;
    private $tmp;

    /**
     * @Route("/rename/{item}", requirements={"path"=".+"})
     * @Route("/{path?}/rename/{item}", requirements={"path"=".+"})
     */
    public function rename(RemoteService $RemoteService, Services $services, Request $request, $id, $path = null, $item) {

      $sftp = $RemoteService->initialize($services);
      $sftp->chdir($id);

      if ($path != null) $sftp->chdir($path);
        $sftp->rename($item,$request->request->get("name"));
        return new JsonResponse($request->request->get("name"));
    }

    /**
     * @Route("/copy")
     * @Route("/{path?}/copy", requirements={"path"=".+"})
     */
    public function copy(RemoteService $RemoteService,Filemanager $Filemanager, Request $request, $id, $path = null, Services $services) {
        $sftp = $RemoteService->initialize($services);
        $sftp->chdir($id);

        if ($path != null) $sftp->chdir($path);

        foreach ($request->query->get("items") as $file) {

            $Filemanager->copy_files(
                $sftp->pwd()."/".$file,
                $sftp->pwd(),
                $sftp
            );
        }
        return $this->redirectToRoute("show_filemanager", [
            "id" => $id,
            "path" => $path,
        ]);
    }

    /**
     * @Route("/create")
     * @Route("/{path?}/create", requirements={"path"=".+"}, defaults={"path" = null})
     */
    public function create(RemoteService $RemoteService, Services $services, Request $request, $id, $path=null,Filemanager $Filemanager)
    {
        // $sftp = $RemoteService->initialize($services);
        // $sftp->chdir($path);

        $sftp = $RemoteService->initialize($services);
        $sftp->chdir($id);
        if ($path != null) $sftp->chdir($path);

        if ($request->query->get("type") == 0) {
            $sftp->put(
                $Filemanager->file_newname($path, "New File.ini", $sftp),
                ""
            );
        } else {
            $sftp->mkdir(
                $Filemanager->file_newname($path, "New Folder", $sftp),
                $mode = -1,
                $recursive = false
            );
        }

        return $this->redirectToRoute("show_filemanager", [
            "id" => $id,
            "path" => $path,
        ]);
    }

    /**
     * @Route("/delete")
     * @Route("/{path?}/delete", requirements={"path"=".+"})
     */
    public function delete(RemoteService $RemoteService, Request $request, $id, $path = null, Services $services) {

      $sftp = $RemoteService->initialize($services);
      $sftp->chdir($id);
      if ($path != null) $sftp->chdir($path);
        foreach ($request->query->get("items") as $key => $value) {
            $sftp->delete($value);
        }

        // return new Response("syccess");
        return $this->redirectToRoute("show_filemanager", [
            "id" => $id,
            "path" => $path,
        ]);
    }
    /**
     * @Route("/save/{item}", requirements={"path"=".+"})
     * @Route("/{path?}/save/{item}", requirements={"path"=".+"})
     */
    public function save(Request $request, $path = null, $item) {
        $sftp->put($item, $request->request->get("test"));
        return new JsonResponse($request->request->get("test"));
    }

    /**
     * @Route("/edit/{item}", requirements={"path"=".+"})
     * @Route("/{path?}/edit/{item}", requirements={"path"=".+"})
     */
    public function open(RemoteService $RemoteService, Request $request, $item, $id, $path=null, Services $services)
    {
        // Set path
        $sftp = $RemoteService->initialize($services);
        $sftp->chdir($id);
        if ($path != null) $sftp->chdir($path);
        // $this->base = "/home/frontliner/";
        // Prevents user from going higher up the directories
        // if (str_contains($path, "..")) {
        //     $path = null;
        // }

            $jsonData = $sftp->get($item);
            $arrData = ["output" => $jsonData];
            return new JsonResponse($arrData);
    }

    /**
     * @Route("/", name="show_filemanager")
     * @Route("/{path?}", name="show_filemanager", requirements={"path"=".+"})
     */
    public function show(RemoteService $RemoteService,Filemanager $Filemanager,Request $request, $path=null, $id, PaginatorInterface $paginator, Services $services) {

        $user = 15;
        $super_user = $services->getServer()->getMonitorLogin();
         // $sftp->chdir('/');
        $sftp = $RemoteService->initialize($services);
        // echo $sftp->pwd();

        $sftp->chdir($id);
        if ($path != null) $sftp->chdir($path);
        $dir = "/home/".$super_user."/".$id;

        echo $dir;

        $files = $Filemanager->scandirSorted($sftp->rawlist()); //$sftp->rawlist();
        $tree = $Filemanager->dir_only($sftp->rawlist("/home/".$super_user."/".$id));

        // $sftp->rawlist("/home/".$services->getServer()->getMonitorLogin()."/".$id)
        // $test = re_test(
        //   ,
        //   $sftp
        // );

        // $test = $sftp->rawlist("/home/".$services->getServer()->getMonitorLogin()."/".$id,true);
        // dump($test);

        $files = $paginator->paginate(
            $files,
            $request->query->getInt("page", 1) /*page number*/,
            $request->query->getInt("limit", 10) /*page number*/
        );

        return $this->render("filemanager/index.html.twig", [
            "results" => $files,
            'tree' => $tree
        ]);
    }
}
