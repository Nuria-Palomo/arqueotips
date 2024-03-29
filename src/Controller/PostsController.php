<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
##use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


class PostsController extends AbstractController
{
    #[Route('/registrar-posts', name: 'registrar-posts')]
    public function index(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger)
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $brochureFile = $form->get('foto')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('ha ocurrido un error');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setFoto($newFilename);
            }

            $user = $this->getUser();
            $post->setUser($user);
            $em = $doctrine->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('posts/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/post/{id}', name:'VerPosts')]
    public function VerPosts($id, Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $post = $em->getRepository(Posts::class)->find($id);
        return $this->render('posts/verPosts.html.twig',['post'=>$post]);
    }

    #[Route('/mis-posts', name: 'MisPosts')]
    public function MisPost(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $user = $this->getUser();
        $posts = $em->getRepository(Posts::class)->findBy(['user'=>$user]);
        return $this->render('posts/MisPosts.html.twig',['posts'=>$posts]);
    }
}
