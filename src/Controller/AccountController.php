<?php

namespace App\Controller;

use App\Entity\user;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\AccountType;
use App\Form\EmailType;
use App\Form\ChangePasswordType;

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
     * @Route("account/login-credentials", name="login-credentials")
     */
    public function credentials(): Response
    {
      $user = $this->getUser();

        return $this->render('account/login_credentials.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("sub-users/create")
     */
    public function  create(Request $request) : Response {
      $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(3);

        $user = new User();

        // creates a task object and initializes some data for this example
        // creates a task object and initializes some data for this example
        // // $user->setUsername('Write a blog post');
        $user->setSubuserOwnerId(3);
        $form = $this->createForm(AccountType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $user = $form->getData();

          $user->setPassword($this->passwordHasher->hashPassword(
             $user,
             'the_new_password'
          ));


          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($user);
          $entityManager->flush();

          return $this->redirectToRoute('users');

        }

      return $this->render('users/form.html.twig',[
        'form' => $form->createView(),
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

    /**
    * @Route("/account/change-email", name="change-email")
    */
    public function  changeEmail(Request $request) : Response {

      $user = $this->getUser();

      $form = $this->createForm(EmailType::class,$user);

      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('account');

      }

      return $this->render('account/change_email.twig',[
        'form' => $form->createView(),
      ]);
    }

    /**
    * @Route("/account/change-password", name="change-password")
    */
    public function  changePassword(Request $request) : Response {

      $user = $this->getUser();

      $form = $this->createForm(ChangePasswordType::class,$user);

      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();

        $user->setPassword($this->passwordHasher->hashPassword(
           $user,
           $user->getPassword()
        ));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('account');

      }

      return $this->render('account/change_password.twig',[
        'form' => $form->createView(),
      ]);
    }

    /**
    * @Route("/account/edit", name="app_account_edit")
    */
    public function  edit(Request $request) : Response {

      $user = $this->getUser();

      $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($user->getId());

      $form = $this->createForm(AccountType::class,$user);

      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('account');

      }

    return $this->render('users/form.html.twig',[
      'form' => $form->createView(),
      'user' => $user
    ]);
    }

}
