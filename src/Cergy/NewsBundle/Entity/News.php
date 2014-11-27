<?php
/**
 * Created by PhpStorm.
 * User: sami
 * Date: 25/11/2014
 * Time: 10:23
 */

namespace Cergy\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Behavior;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="news")
 * @author Sami Errighi
 * @JMS\ExclusionPolicy("all")
 */
class News
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @JMS\Expose
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @JMS\Expose
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Cergy\UserBundle\Entity\User", inversedBy="news")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @JMS\Expose
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @Behavior\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     * @Behavior\Timestampable(on="update")
     */
    private  $updatedAt;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return news
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


} 