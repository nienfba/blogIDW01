<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Form\ArticleType;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
           
        ]);
    }
    
    
    /**
     * @Route("/admin/article/list", name="listArticles")
     */
    public function listeArticles(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findBy([],['publishedAt' => 'DESC']);
        return $this->render('admin/listArticles.html.twig', [
            'articles'  =>  $articles
        ]);
    }
    
    /**
     * @Route("/admin/article/valide/{id}", name="valideArticle")
     */
    public function valideArticle(Article $article, EntityManagerInterface $entityManager)
    {
        $article->setValide(!$article->getValide());
        $entityManager->persist($article);
        $entityManager->flush();

        $this->addFlash('success', 'Status de l\'article modifié !');

        return $this->redirectToRoute('listeArticles');
    }

    /**
     * @Route("/admin/article/delete/{id}", name="deleteArticle")
     */
    public function deleteArticle(Article $article, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('listeArticles');
    }
    
    
    
     /**
     * @Route("/admin/article/edit/{id}", name="editArticle")
     * @Route("/admin/article/add", name="addArticle")
     */
    public function addArticle(Article $article=null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if($article == null)
            $article = new Article();
        
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $article->setCreatedAt(new \DateTime()); 
            $entityManager->persist($article);
            $entityManager->flush();
            
            if($article->getId() == null)
                $this->addFlash('success', 'Article ajouté !');
            else
                $this->addFlash('success', 'Article Modifié !');
                
            return $this->redirectToRoute('listArticles');
        }
        
        return $this->render('admin/addArticle.html.twig', [
           "form"=>$form->createView()
        ]);
    }
}
