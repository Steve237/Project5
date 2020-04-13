<?php

namespace App\src\Controller;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;

class FrontController {

    private $articleDAO;
    private $commentDAO;

    public function __construct() 
    {

        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
    }

    public function home() 
    {

        require '../templates/homepage.php';

    }

    public function articles() 
    {

        $article = $this->articleDAO->getArticles();
        require '../templates/posts.php';
    }

    public function single($idArt) 
    {

        $singlepost = $this->articleDAO->getArticle($idArt);
        $comment = $this->commentDAO->getCommentsFromArticle($idArt);
        require '../templates/single.php';
    }

}