<?php

namespace App\src\Controller;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
use App\src\model\View;

class FrontController {

    private $articleDAO;
    private $commentDAO;
    private $view;

    public function __construct() 
    {

        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
    
    
    }

    public function home() 
    {

        $this->view->render('homepage');

    }

    public function articles() 
    {

        $article = $this->articleDAO->getArticles();
        $this->view->render('posts', ['article' => $article]);
    }

    public function single($idArt) 
    {

        $singlepost = $this->articleDAO->getArticle($idArt);
        $comment = $this->commentDAO->getCommentsFromArticle($idArt);
        $this->view->render('single', [
            'singlepost' => $singlepost,
            'comment' => $comment
        ]);
    }

}