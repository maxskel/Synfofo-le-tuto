<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\ArticleBundle\Controller;

use DateTime;
use OC\ArticleBundle\Entity\Article;
use OC\ArticleBundle\Entity\Image;
use OC\ArticleBundle\Task\TaskArticle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



/**
 * Description of ArticleController
 *
 * @author qwerty
 */
class ArticleController extends Controller{
    //put your code here
    
    public function editAction($id , Request $request){
        
        $doctrineManager = $this->getDoctrine()->getManager();
        $doctrineRepository = $doctrineManager->getRepository(Article::class);
        
        /* @var $article Article */
        $article = $doctrineRepository->find($id);

        $username = null;
        $userId = null;

        if($this->getUser()){
            $username = $this->getUser()->getUsername();
            $userId = $this->getUser()->getId();
        }

        if($article->getUser() === null || $userId != $article->getUser()->getId()){
            throw $this->createAccessDeniedException('Mauvais utilisateur pour larticle bitchez! ');
        }

        //$task = new TaskArticle();
        $form = $this->createForm(TaskArticle::class , $article);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ){
            
            $doctrine = $this->getDoctrine();
            $doctrineManager = $doctrine->getManager();


            /* Test ORM OneToOne / ManyToOne / ManyToMany */
            $doctrineManager->persist($article);
            $doctrineManager->flush();
            
            $request->getSession()->getFlashBag()->add("formValidate","Bravo l'article (".$article->getTitle().") a bien été Modifier");
            return $this->redirectToRoute("oc_article_control");
        }
        
         return $this->render("@OCArticle/Article/edit.html.twig", [ 'form' => $form->createView()]);
    }
    
    public function removeAction($id, Request $request){
        $doctrineManager = $this->getDoctrine()->getManager();
        $article = $doctrineManager->find("OC\ArticleBundle\Entity\Article", $id);

        $username = null;
        $userId = null;

        if($this->getUser()){
            $username = $this->getUser()->getUsername();
            $userId = $this->getUser()->getId();
        }

        if($userId != $article->getUser()->getId()){
            throw $this->createAccessDeniedException('Mauvais utilisateur pour larticle bitchez! ');
        }


        if($article != null){
            $doctrineManager->remove($article);
            //$doctrineManager->persist($article);
            $doctrineManager->flush();
        }else{
            return new Response("Cette article n'existe pas!");
        }
        
        return new Response("Article suprimmer! ID: ".$id." par l'admin");
    }
    
    public function newAction(Request $request){

        $article =  new Article;
        $form = $this->createForm( TaskArticle::class , $article );
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ){
            
            $doctrine = $this->getDoctrine();
            $doctrineManager = $doctrine->getManager();
            $username = null;

            if($this->getUser()){
                $username = $this->getUser()->getUsername();
            }


            $article->setUser( $this->getUser() );

            $article->setImage(new Image());
            $imgArticle = $article->getImage();
            $imgArticle->setAlt("Image de cette article lol");
            $imgArticle->setUrl("https://blaguesquebec882.files.wordpress.com/2017/04/cropped-cropped-normal-jpg2.png?w=200");
            
            $doctrineManager->persist($article);
            $doctrineManager->flush();
            
            $request->getSession()->getFlashBag()->add("formValidate","Bravo l'article (".$article->getTitle()." de ".$this->getUser()->getUsername().") a bien été envoyer");
            
        }
        
        return $this->render("@OCArticle/Article/new.html.twig", [ 'form' => $form->createView()]);
    }
    
    public function indexAction(Request $request, $id=null){
        
        $doctrineManager = $this->getDoctrine()->getManager();
        $repositoryArticle = $doctrineManager->getRepository("OC\ArticleBundle\Entity\Article");

        $article = new Article();

        if($id == null)
            $articles = $repositoryArticle->findAll();
        else
            $articles = [ $repositoryArticle->find($id) ];
        
        $final="";
        $i = 0;

        foreach( $articles as $unit ) {
            $link = "";
            $urlEdit = $this->get("router")->generate("oc_article_edit", [ 'id' => $unit->getId() ] );
            $urlArticle = $this->get("router")->generate("oc_article_control", [ 'id' => $unit->getId() ]);

            if ($unit->getUser() != null) {


                if ($unit->getImage() != null)
                    $final = "<img src='" . $unit->getImage()->getUrl() . "' />".$final;

                if($this->isGranted('ROLE_USER') && $unit->getUser() === $this->getUser()){
                    $link = '<a href="'.$urlArticle.'"> Lien vers larticle! </a>';
                }

                $final = "<h1> " . $unit->getTitle() . " ID: " . $unit->getId() . " User: " . $unit->getUser()->getUsername() . "</h1>".
                    "<p>" . $unit->getString() . " </p>".
                '<form methos="GET" action="'.$urlEdit.'">
                    <input type="submit" value="Editer Article" />
                </form>
                '.$link.$final;
            }
        }
        
       // return new Response($final);
        return $this->render("@OCArticle/Article/index.html.twig" , [ "articles" => $final]);
    }
}