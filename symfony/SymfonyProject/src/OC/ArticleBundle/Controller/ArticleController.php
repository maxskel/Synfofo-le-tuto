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
        
        $dm = $this->getDoctrine()->getManager();
        $dr = $dm->getRepository("OC\ArticleBundle\Entity\Article");
        
        /* @var $article Article */
        $article = $dr->find($id);
        
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class)
            ->add('string', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ){
            
            $doctrine = $this->getDoctrine();
            $doctrineManager = $doctrine->getManager();
            
            
            $article->setTitle($form->getData()->getTitle());
            $article->setString( $form->getData()->getString() );
            
            /* Test ORM OneToOne / ManyToOne / ManyToMany */
            
            
            
            $doctrineManager->persist($article);
            $doctrineManager->flush();
            
            $request->getSession()->getFlashBag()->add("formValidate","Bravo l'article (".$article->getTitle().") a bien été Modifier");
            return $this->redirectToRoute("oc_article_control");
        }
        
         return $this->render("@OCArticle/Article/edit.html.twig", [ 'form' => $form->createView()]);
    }
    
    public function removeAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $article = $em->find("OC\ArticleBundle\Entity\Article", $id);
        
        if($article != null){
            $em->remove($article);
            //$em->persist($article);
            $em->flush();
        }else{
            return new Response("Cette article n'existe pas!");
        }
        
        return new Response("Article suprimmer! ID: ".$id." par l'admin");
    }
    
    public function newAction(Request $request){
        
        $task = new Task();
        
        $form = $this->createFormBuilder($task)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ){
            
            $doctrine = $this->getDoctrine();
            $doctrineManager = $doctrine->getManager();
            
            $article =  new Article;
            
            $article->setTitle($form->getData()->getTitle());
            $article->setString( $form->getData()->getDescription() );
            
            $article->setImage(new Image());
            $imgArticle = $article->getImage();
            $imgArticle->setAlt("Image de cette article lol");
            $imgArticle->setUrl("https://blaguesquebec882.files.wordpress.com/2017/04/cropped-cropped-normal-jpg2.png?w=200");
            
            $doctrineManager->persist($article);
            $doctrineManager->flush();
            
            $request->getSession()->getFlashBag()->add("formValidate","Bravo l'article (".$article->getTitle().") a bien été envoyer");
            
        }
        
        return $this->render("@OCArticle/Article/new.html.twig", [ 'form' => $form->createView()]);
    }
    
    public function indexAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        
        $repoImg = $em->getRepository("OC\ArticleBundle\Entity\Image")->findAll()[0];
        $repoArray = $em->getRepository("OC\ArticleBundle\Entity\Article")->findBy(["image" => $repoImg]);
        $repo = $em->getRepository("OC\ArticleBundle\Entity\Article");
        
        
        
        $article = new Article();
        $articles = $repo->findAll();
        
        $final="";
        $i = 0;
        
        foreach( $articles as $unit ){
            
                $final .= "<h1> ".$unit->getTitle()." ID: ".$unit->getId()."</h1>";
           
                $final .= "<p>". $unit->getString() ." </p>";
                
                if($unit->getImage() != null)
                    $final .= "<img src='". $unit->getImage()->getUrl() ."' />";
            
        }
        
        return new Response($final);
    }
}


class Task
{
    protected $title;
    protected $description;

    public function setTitle($title){
        $this->title = $title;
    }
    
    public function getTitle(){
        return $this->title;
    }
    
    public function setDescription($description){
        $this->description = $description;
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }
}