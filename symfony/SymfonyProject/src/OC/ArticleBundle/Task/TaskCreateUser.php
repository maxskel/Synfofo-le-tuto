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
    protected $username;
    protected $password;


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("_username" , TextType::class)
            ->add("_password" , TextType::class)
            ->add("save" , SubmitType::class);
    }


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