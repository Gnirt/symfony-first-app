<?php
/**
 * Created by PhpStorm.
 * User: ptring
 * Date: 22/10/2014
 * Time: 13:10
 */

namespace Gobelins\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Behavior;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Book
 *
 * @ORM\Table()
 * @ORM\Table(name="book")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Book
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Expose()
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Expose()
     */
    private $publication;

    /**
     * @ORM\Column(type="text")
     * @Expose()
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Expose()
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Gobelins\UserBundle\Entity\User", inversedBy="Book")
     * @ORM\JoinColumn(name="author", referencedColumnName="id", nullable=false)
     * @Expose()
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Gobelins\BookBundle\Entity\Category", inversedBy="Book")
     * @ORM\JoinColumn(name="category", referencedColumnName="id", nullable=false)
     * @Expose()
     */
    private $category;

    /**
     * @Behavior\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @Expose()
     */
    private $createdAt;

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
     * @Behavior\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

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

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param mixed $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
