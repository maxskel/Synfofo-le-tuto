<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\ArticleBundle\Controller;

use OC\ArticleBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Description of LoginController
 *
 * @author qwerty
 */
class LoginController extends Controller{
    //put your code here
    
public function loginAction(Request $request){

    $user = $this->getUser();
    $error = "Pas derreur";
    $lastUserName = "null";

    //$this->get('security');
    if($user == null){
        $error = "ERROR: Utilisateur anon";
    }else{
        $error = "ERROR: vrais utilisateur autentifier derierre parfeu";
        $lastUserName = $user->getUsername();
    }


    // Le service authentication_utils permet de récupérer le nom d'utilisateur
    // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
    // (mauvais mot de passe par exemple)
    $authenticationUtils = $this->get('security.authentication_utils');
        
        
        return $this->render("@OCArticle/Login/login.html.twig", [ "error" => $authenticationUtils->getLastAuthenticationError() , "last_username" => $authenticationUtils->getLastUsername()]);
    }
    
    public function loginCheckAction(Request $request){
        return $this->render("@OCArticle/Login/logout.html.twig");
    }
    
    public function logoutAction(Request $request){
        
        return $this->render("@OCArticle/Login/logout.html.twig");
    }

    public function createUserAction(Request $request){
        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('_username', TextType::class)
            ->add('_password', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $doctrine = $this->getDoctrine();
            $doctrineManager = $doctrine->getManager();
            $user = new User();

            $user->setUsername($form->getData()->getUsername());
            $user->setPassword($form->getData()->getPassword());
            $user->setSalt('');
            $user->setRoles( array('ROLE_USER') );

            $doctrineManager->persist($user);
            $doctrineManager->flush();
        }

        return $this->render("@OCArticle/Login/create-user.html.twig", [ 'form' => $form->createView()]);
    }
    
}

class Task{
    protected $username;
    protected $password;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $name
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}