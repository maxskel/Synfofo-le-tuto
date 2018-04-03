<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\ArticleBundle\Controller;

use DateTime;
use OC\ArticleBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
        
        $article1 = $dr->find($id);
        
        $form = $this->createFormBuilder($article1)
            ->add('title', TextType::class)
            ->add('string', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ){
            
            $doctrine = $this->getDoctrine();
            $doctrineManager = $doctrine->getManager();
            
            $article =  $article1;
            
            $article->setTitle($form->getData()->getTitle());
            $article->setString( $form->getData()->getString() );
            
            $doctrineManager->persist($article);
            $doctrineManager->flush();
            
            $request->getSession()->getFlashBag()->add("formValidate","Bravo l'article (".$article->getTitle().") a bien été Modifier");
            return $this->redirectToRoute("oc_article_control");
        }
        
         return $this->render("@OCArticle/Article/edit.html.twig", [ 'form' => $form->createView()]);
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
            
            $doctrineManager->persist($article);
            $doctrineManager->flush();
            
            $request->getSession()->getFlashBag()->add("formValidate","Bravo l'article (".$article->getTitle().") a bien été envoyer");
            
        }
        
        return $this->render("@OCArticle/Article/new.html.twig", [ 'form' => $form->createView()]);
    }
    
    public function indexAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("OC\ArticleBundle\Entity\Article");
        
        $article = new Article();
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