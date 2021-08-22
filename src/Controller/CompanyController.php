<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CompanyInfo;
use App\Form\Type\CompanyInfoType;

class CompanyController extends AbstractController
{

    public function show(): Response
    {
      $info = $this->getDoctrine()
            ->getRepository(CompanyInfo::class)
            ->find(1);

      return $this->render('shared\header.html.twig',
        [
          'companyInfo' => $info
        ]);
    }

          /**
          * @Route("/system/company")
          */
        public function  form(Request $request) : Response {

          $info = $this->getDoctrine()
                ->getRepository(CompanyInfo::class)
                ->find(1);

          $form = $this->createForm(CompanyInfoType::class,$info);

          $form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()) {
            $company = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('system');

          }

        return $this->render('company\index.html.twig',[
          'form' => $form->createView(),
        ]);



        }
}
