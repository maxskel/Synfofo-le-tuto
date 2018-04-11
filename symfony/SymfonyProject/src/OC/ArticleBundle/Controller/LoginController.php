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
        //$this->get("security");
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
    
}
