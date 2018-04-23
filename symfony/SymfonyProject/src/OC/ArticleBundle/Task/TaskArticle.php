<?php
/**
 * Created by PhpStorm.
 * User: qwerty
 * Date: 2018-04-23
 * Time: 15:04
 */

namespace OC\ArticleBundle\Task;


class TaskArticle
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