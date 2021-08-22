<?php

namespace App\Controller;

use App\Entity\SupportTickets;
use App\Form\TicketType;
use App\Form\TicketReplyType;
use App\Entity\SupportTicketReplies;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class SupportController extends AbstractController
{
    /**
     * @Route("/support", name="support")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {


      $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(SupportTickets::class);
        $query = $repository
            ->createQueryBuilder('t')
            ->where('t.userId = :uid' )
            ->setParameter('uid',  $user->getId())
            ->getQuery();

        $tickets = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1) /*page number*/,
            $request->query->getInt('limit', 10) /*page number*/
        );
      if (empty($tickets)) {
          throw $this->createNotFoundException(
              'No results found'
          );
      }

      dump($tickets);


        return $this->render('support/index.html.twig', [
          'results' => $tickets,
        ]);
    }

    /**
     * @Route("/support/create", name="support_form")
     */
    public function create(Request $request, PaginatorInterface $paginator): Response
    {

      $user = $this->getUser();

      $ticket = new SupportTickets;
      $ticket->setuser($user);

      $reply = new SupportTicketReplies;
      $reply->setUser($user);

      $ticket->addReply($reply);
      $ticket->setSupportCatId(1);
      $form = $this->createForm(TicketType::class,$ticket);

      dump($ticket);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        $time = time();

        $ticket = $form->getData();
        $ticket->setCreatedOn($time);

        $reply = $ticket->getReplies()[0];
        $reply->setCreatedOn($time);
        $reply->setUserId($user->getId());
        $reply->setTicketId($reply->getTicketId());




          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($ticket);
          $entityManager->flush();

        return $this->redirectToRoute('support');

      }


      return $this->render('tickets/form.html.twig',[
        'form' => $form->createView(),
      ]);

    }

    /**
     * @Route("/support/{id}", name="support_ticket")
     */
    public function item(Request $request, PaginatorInterface $paginator, $id, SupportTickets $ticket): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(TicketReplyType::class);

        $replies = $paginator->paginate(
            $ticket->getReplies(),
            $request->query->getInt('page', 1) /*page number*/,
            $request->query->getInt('limit', 10) /*page number*/
        );



        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
              $reply = $form->getData();

              $reply->setCreatedOn(time());
              $reply->setUser($user);
              $reply->setSupportTickets($ticket);

              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($reply);
              $entityManager->flush();

            return $this->redirectToRoute('support_ticket',[
              'id' => $id
            ]);
        }
        if (empty($ticket)) {
            throw $this->createNotFoundException(
                'No results found'
            );
        }

        return $this->render('support/item.html.twig', [
          'results' => $ticket,
          'replies' => $replies,
          'form' => $form->createView(),
        ]);
    }
}
