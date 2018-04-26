<?php

namespace OC\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="OC\ArticleBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     *@ORM\ManyToOne(targetEntity="OC\ArticleBundle\Entity\Image", cascade={"persist"})
     * @var type 
     */
    private $image;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="string", type="text")
     */
    private $string;

    /**
     * @ORM\ManyToOne(targetEntity="OC\ArticleBundle\Entity\User" , cascade={"persist"})
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set string
     *
     * @param string $string
     *
     * @return Article
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set image
     *
     * @param \OC\ArticleBundle\Entity\Image $image
     *
     * @return Article
     */
    public function setImage(\OC\ArticleBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\ArticleBundle\Entity\Image
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     */
    public function getUser() : ?User
    {
        return $this->user;
    }

    /**
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
