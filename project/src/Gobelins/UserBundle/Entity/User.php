<?php
/**
 * Created by PhpStorm.
 * User: ptring
 * Date: 26/09/2014
 * Time: 14:32
 */

namespace Gobelins\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Class User
 * @package Gobelins\UserBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 * @ExclusionPolicy("ALL")
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
     * @ORM\OneToMany(targetEntity="Gobelins\NewsBundle\Entity\News", mappedBy="author")
     */
    protected $news;

    /**
     * @ORM\OneToMany(targetEntity="Gobelins\BookBundle\Entity\Book", mappedBy="author")
     */
    protected $book;
}