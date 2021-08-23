<?php

namespace App\Controller;

use App\Entity\user;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
      $user = $this->getUser();

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/login-credentials", name="login-credentials")
     */
    public function credentials(): Response
    {
      $user = $this->getUser();

        return $this->render('account/login_credentials.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/sub-users", name="sub-users")
     */
    public function sub_users(Request $request, PaginatorInterface $paginator): Response
    {
      $user = $this->getUser();

            $id = 3;

            $em = $this->getDoctrine()->getManager();

            $usersRepository = $em->getRepository(User::class);

            $allUsersQuery = $usersRepository->createQueryBuilder('u')
             ->where('u.ownerId = :owner')
             ->setParameter('owner', $id)
             ->getQuery();


             $users = $paginator->paginate(
                 // Doctrine Query, not results
                 $allUsersQuery,
                 // Define the page parameter
                 $request->query->getInt('page', 1), /*page number*/
                 $request->query->getInt('limit', 10), /*page number*/
             );



            $roles = $this->getDoctrine()
                  ->getRepository(\App\Entity\Role::class)
                  ->findAll();

        return $this->render('account/sub-users.twig', [
          "results" => $users,
          "roles" => $roles,
        ]);
    }
}
