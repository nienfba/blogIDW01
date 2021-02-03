<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Entity\Category;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $repository): Response
    {
        $articles = $repository->findAll();
        
        return $this->render('blog/index.html.twig', [
            "articles"=>$articles
        ]);
    }
    
    /**
     * @Route("/post/{id}", name="post")
     */
    public function post(Article $article,ArticleRepository $repository): Response
    {

        $articlesByCategory = $repository->findByCategory($article->getCategory()->getId());

        return $this->render('blog/post.html.twig', [
            "article"=>$article,
            "articlesByCategory"=>$articlesByCategory
        ]);
    }
    
     /**
     * @Route("/category/{id}", name="category")
     */
    public function category(Category $category): Response
    {

        return $this->render('blog/category.html.twig', [
            "category"=>$category
        ]);
    }
    
}
