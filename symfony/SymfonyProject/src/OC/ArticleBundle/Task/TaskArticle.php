<?php
/**
 * Created by PhpStorm.
 * User: qwerty
 * Date: 2018-04-23
 * Time: 15:04
 */

namespace OC\ArticleBundle\Task;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskArticle extends AbstractType
{

    protected $title;
    protected $description;


    public function buildForm(FormBuilderInterface $formBuilder, array $option){
        $formBuilder
            ->add("title" , TextType::class)
            ->add("description" , TextType::class)
            ->add("save" , SubmitType::class);
    }


}