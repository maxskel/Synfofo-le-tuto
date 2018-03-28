<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OC\ArticleBundle\Entity\Article;


/**
 * Description of ArticleController
 *
 * @author qwerty
 */
class ArticleController extends Controller{
    //put your code here
    
    public function indexAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("OCArticleBundle:Article");
        
        $article = new Article();
        $article->setTitle("Titre random: ".rand());
        $article->setString("text d'article random lol :/..");
        
        $em->persist($article);
        $em->flush();
        
        $articles = $repo->findAll();
        
        $final="";
        $i = 0;
        
        foreach( $articles as $unit ){
            
                $final .= "<h1> ".$unit->getTitle()." </h1>";
           
                $final .= "<p>". $unit->getString() ." </p>";
            
        }
        
        return new Response($final);
    }
}
