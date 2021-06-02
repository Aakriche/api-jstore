<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $repoArticle;

    public function __construct(ArticleRepository $repoArticle, CategoryRepository $repoCategory)
    {
        $this->repoArticle = $repoArticle;
        $this->repoCategory = $repoCategory;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $categories = $this->repoCategory->findAll();
        $articles = $this->repoArticle->findAll();

        return $this->render("home/index.html.twig", [
        'articles' => $articles, 
        'categories' => $categories,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Article $article): Response
    {
      

        if(!$article){
            return $this->redirectToRoute('home');
        }

        return $this->render("show/index.html.twig", ['article' => $article,
        ]);
    }

    /**
     * @Route("/showCategory/{id}", name="show_category")
     */
    public function showCategory(Category $category): Response
    {
      
        $articles = $category->getArticles();
        $categories = $this->repoCategory->findAll();


        return $this->render("showCategory/index.html.twig", [
            'category' => $category,
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}
