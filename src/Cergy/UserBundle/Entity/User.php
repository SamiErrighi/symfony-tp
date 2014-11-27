<?php

namespace Cergy\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\OneToMany(targetEntity="Cergy\NewsBundle\Entity\News", mappedBy="user")
     */
    private $news;

    /**
     *@ORM\OneToMany(targetEntity="Cergy\BookBundle\Entity\Book", mappedBy="user")
     */
    private $books;

    public function __construct()
    {
        parent::__construct();
        $this->news = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param mixed $news
     * @return user
     */
    public function setNews($news)
    {
        $this->news = $news;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param mixed $books
     */
    public function setBooks($books)
    {
        $this->books = $books;
    }

}