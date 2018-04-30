<?php
/**
 * Created by PhpStorm.
 * User: qwerty
 * Date: 2018-04-23
 * Time: 15:03
 */

namespace OC\ArticleBundle\Task;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskCreateUser extends AbstractType {
    public $_username;
    public $_password;


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("_username" , TextType::class)
            ->add("_password" , TextType::class)
            ->add("save" , SubmitType::class);
    }

}