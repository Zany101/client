<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ServiceCustomCmdlines;
use Symfony\Component\HttpFoundation\Request;

use Knp\Component\Pager\PaginatorInterface;
use App\Form\CommandFormType;
use App\Entity\Services;
use App\Entity\User;
/**
* @Route("/services/{id}/command" ,name="command_line")
*/
class CommandLineController extends AbstractController
{
    /**
     * @Route(name="command_line")
     */
    public function index(Request $request, $id, PaginatorInterface $paginator) : Response {

      // $user = $this->get('security.token_storage')->getToken()->getUser();

      // $id = $user->getId();

      $em = $this->getDoctrine()->getManager();

      $servicesRepository = $em->getRepository(ServiceCustomCmdlines::class);

      $allServicesQuery = $servicesRepository->createQueryBuilder('u')
       ->where('u.serviceId = :service')
       ->setParameter('service', $id)
       ->getQuery();

      $services = $paginator->paginate(
          $allServicesQuery, /* query NOT result */
          $request->query->getInt('page', 1), /*page number*/
          $request->query->getInt('limit', 10), /*page number*/
      );


        return $this->render('command_line/index.html.twig',
      [
        'results' => $services
      ]);

    }

    /**
    * @Route("/create")
    */
    public function  create(Request $request,$id, Services $service) : Response {

      $command =  new ServiceCustomCmdlines;
      $command->setServiceId($id);
      $command->setServices($service);

      $form = $this->createForm(CommandFormType::class, $command);

      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {

        // $form->getData() holds the submitted values
         // but, the original `$task` variable has also been updated
         $command = $form->getData();
         if (strpos($command->getCmdline(), ',') !== false) {
           $string = str_replace(' ', '', $command->getCmdline());
           $val = null;
           foreach (explode(',', $string) as $key => $value) {
             $val .= "?".$value.", ";
           }
            $command->setCmdline($val);
         }
         // ... perform some action, such as saving the task to the database
         // for example, if Task is a Doctrine entity, save it!

         // if (preg_match('/(?i)port|slots/', $command->getCmdline(),  $matches, PREG_OFFSET_CAPTURE)) {
         //   print_r($matches);
         // }

         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($command);
         $entityManager->flush();

      return $this->redirectToRoute('command', ['id' => $id]);
      }
      // Needs function To remove reserved parameters


      return $this->render('command_line/create.html.twig',
      [
        'form' => $form->createView(),
        'services' => $service
      ]);
    }

    /**
    * @Route("/{cmd}" )
    */
    public function  edit(Request $request,$id,$cmd) : Response {

            $service = $this->getDoctrine()->getRepository(Service::class)->find($id);

            $command = $this->getDoctrine()->getRepository(ServiceCustomCmdlines::class)->find($cmd);

            $command->setService($service);

              $command->setCmdline(str_replace(array("?",  "-"), "", $command->getCmdline()));

            if (!$service) {
                 throw $this->createNotFoundException();
             }

            $form = $this->createForm(CommandFormType::class,$command);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {

               $cmd = $form->getData();
               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->flush();

            return $this->redirectToRoute('command_line', ['id' => $id]);
            }

      return $this->render('command_line/create.html.twig',
      [
        'form' => $form->createView(),
        'services' => $service
      ]);
    }


    /**
    * @Route("{cmd}/delete" )
    */
    public function  delete(Request $request,$id,$cmd) : Response {

            $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
            $command = $this->getDoctrine()->getRepository(GameServiceCustomCmdlines::class)->find($cmd);
            $command->setService($service);

            if (!$service) {
                 throw $this->createNotFoundException();
             }

               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->remove($command);
               $entityManager->flush();

            return $this->redirectToRoute('command', ['id' => $id]);
     }
}
