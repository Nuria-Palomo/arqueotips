<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(Request $request, ManagerRegistry $doctrine)
    {
        $user = $this->getUser(); //OBTENGO AL USUARIO ACTUALMENTE LOGUEADO
        if($user){
          $em = $doctrine->getManager();
          $query = $em->getRepository(Posts::class)->findAll();

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'Bienvenido a mi Dashboard',
        ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }
}