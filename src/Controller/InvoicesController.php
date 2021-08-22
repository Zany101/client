<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoicesController extends AbstractController
{
    /**
     * @Route("/invoices", name="invoices")
     */
    public function index(): Response
    {
        return $this->render('invoices/index.html.twig', [
            'controller_name' => 'InvoicesController',
        ]);
    }
}
