<?php
/**
 * Created by PhpStorm.
 * User: ptring
 * Date: 25/09/2014
 * Time: 12:10
 */

namespace Gobelins\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Behavior;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Class News
 * @package Gobelins\NewsBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="news")
 * @ExclusionPolicy("all")
 */
class News
{

    /* NORME
    public function test()
    {
        if (true) {
            //blabla
        } elseif (false) {
            //another blabla
        } else {
            //other
        }

        for (;;) {

        }
    }
    */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose()
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Expose()
     */
    private $title;
    /**
     * @ORM\Column(type="text")
     * @Expose()
     */
    private $content;

    /**
     * @Behavior\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @Expose()
     */
    private $createdAt;

    /**
     * @Behavior\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Gobelins\UserBundle\Entity\User", inversedBy="News")
     * @ORM\JoinColumn(name="author", referencedColumnName="id", nullable=false)
     * @Expose()
     */
    private $author;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }


}