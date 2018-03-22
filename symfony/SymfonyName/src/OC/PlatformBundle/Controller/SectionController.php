<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SectionController extends Controller{
	
	public function gameAction(Request $request){
		
		$text = $request->request->get("text");
		$random = $request->request->get("randomNumber");
		
		if($text == null || $text == -1){
			$random = rand(0,99);
			$text = 0;
		}
		
		return $this->render("@OCPlatform/Section/article.html.twig", ["text" => $text , "randomNumber" => $random ]);
	}
	
}