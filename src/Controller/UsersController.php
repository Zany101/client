<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Form\UserType;
/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{


      private $passwordHasher;

      public function __construct(UserPasswordHasherInterface $passwordHasher)
      {
        $this->passwordHasher = $passwordHasher;
      }

    /**
     * @Route("/create")
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
        $form = $this->createForm(UserType::class,$user);

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
    * @Route("/{id}/delete")
    */
    public function  delete($id) {


      $users = $this->getDoctrine()->getRepository(User::class)->find(['id' => $id]);

      if (!$users) {
           throw $this->createNotFoundException();
       }

         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($users);
         $entityManager->flush();

      return $this->redirectToRoute('users');
    }


    /**
    * @Route("/{id}")
    */
    public function  edit(Request $request, $id) : Response {
      $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

      $form = $this->createForm(UserType::class,$user);

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

        return $this->redirectToRoute('users');

      }

    return $this->render('users/form.html.twig',[
      'form' => $form->createView(),
      'user' => $user
    ]);
    }

    /**
    * @Route("", name="users")
    */
    public function  list(Request $request, PaginatorInterface $paginator) : Response {

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



      return $this->render('users/index.html.twig',[
        "results" => $users,
        "roles" => $roles,
      ]);
    }
}
