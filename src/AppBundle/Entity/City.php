<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 23.11.17
 * Time: 15:42
 */
/**
* @ORM\Entity
* @ORM\Table(name="city")
*/
class City
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Hero", mappedBy="city")
     */
    private $heroes;

    public function __construct()
    {
        $this->heroes = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getHeroes()
    {
        return $this->heroes;
    }

    /**
     * @param mixed $heroes
     */
    public function setHeroes($heroes)
    {
        $this->heroes = $heroes;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}