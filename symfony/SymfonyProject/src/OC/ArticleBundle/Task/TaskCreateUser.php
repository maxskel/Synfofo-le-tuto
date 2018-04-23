<?php
/**
 * Created by PhpStorm.
 * User: qwerty
 * Date: 2018-04-23
 * Time: 15:03
 */

namespace OC\ArticleBundle\Task;


class TaskCreateUser{
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