<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator )
    {
        $user = $this->getUser(); //OBTENGO AL USUARIO ACTUALMENTE LOGUEADO
        if($user){
          $em = $doctrine->getManager();
          #$query = $em->getRepository(Posts::class)->findAll();
          $query = $em->getRepository(Posts::class)->BuscarPosts();
          $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*número página*/
            2 /*limite por página*/
        );


        return $this->render('dashboard/index.html.twig', [
            'pagination' => $pagination
        ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }
}