<?php

namespace App\Controller;

use App\Entity\GetItemDetails;
use App\Entity\Order;
use App\Entity\OrderItems;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Games;
use App\Entity\Services;
use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\OrderType;
use Symfony\Component\HttpFoundation\RequestStack;


class GamesController extends AbstractController
{

  public function __construct(RequestStack $requestStack)
  {
      $this->requestStack = $requestStack;
  }

  public function popular(Request $request, PaginatorInterface $paginator): Response
  {
        // $user = $this->get('security.token_storage')->getToken()->getUser();
        // $id = $user->getId();

        $id = 3;
        $em = $this->getDoctrine()->getManager();

        $gamesRepository = $em->getRepository(Games::class);

        $allServicesQuery = $gamesRepository->createQueryBuilder('g')->getQuery();


         $games = $paginator->paginate(
             // Doctrine Query, not results
             $allServicesQuery,
             // Define the page parameter
             $request->query->getInt('page', 1), /*page number*/
             $request->query->getInt('limit', 3), /*page number*/
         );


        return $this->render('product/popular.html.twig',
      [
        'results' => $games
      ]);
  }
    /**
     * @Route("/product")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

          $id = 3;
          $em = $this->getDoctrine()->getManager();

          $gamesRepository = $em->getRepository(Games::class);

          $allServicesQuery = $gamesRepository->createQueryBuilder('g')->getQuery();


           $games = $paginator->paginate(
               // Doctrine Query, not results
               $allServicesQuery,
               // Define the page parameter
               $request->query->getInt('page', 1), /*page number*/
               $request->query->getInt('limit', 24), /*page number*/
           );


          return $this->render('product/index.html.twig',
        [
          'results' => $games,
          'nav' => true
        ]);
    }

    /**
     * @Route("/product/{id}")
     */
    public function item(Games $game,RequestStack $requestStackRequest,Request $request, Games $games, $id): Response
    {
          // $user = $this->get('security.token_storage')->getToken()->getUser();
          // $id = $user->getId();
          $session = $this->requestStack->getSession();
          $session->start();

          $cart = $this->getDoctrine()
                ->getRepository(Order::class)
                ->findOneBy([
                  'session' => $session->getId()
                ]);

          if (!$cart) {
            $cart = new Order;
            $cart->setCreated(time());
            $cart->setSession($session->getId());
          }



          // dump($cart);
          $item = new OrderItems();
          $item->setProduct($game);
          // dump($item);

          $form = $this->createForm(OrderType::class, $item);


          $form->handleRequest($request);

          if($form->isSubmitted() && $form->isValid()) {

            $item = $form->getData();


              $cart->setCreated(time());
              $cart->setSession($session->getId());
              $cart->setCurrency("eur");
              $cart->setTotal("99");

              $cart->addItem($item);

              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($cart);
              $entityManager->flush();

              // return $this->redirectToRoute('system');
            //
            // $item = $form->getData();
            // // Get Value from session
            // $cart = $session->get('cart');
            // // Append value to retrieved array.
            // $cart[] = $item;
            // // Set value back to session
            // $session->set('cart', $cart);
            //
            // $form = $form->getData();
            // $items = $session->get('cart');
            // $items = array_push($items, $form);
            // $session->set('cart',[
            //     $items
            // ]);

            return $this->redirectToRoute('summary');

          }


          return $this->render('product/form.html.twig',[
            'form' => $form->createView(),
            'game' => $games
          ]);
    }


}
