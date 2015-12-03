<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dunglas\ApiBundle\Annotation\Iri;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Basket
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Basket
{

    /**
     * @var int
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string The name of the item.
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="FoodBasket", mappedBy="basket")
     */
    private $foods;

    /**
     * @var string An image of the item. This can be a [URL](http://schema.org/URL) or a fully described [ImageObject](http://schema.org/ImageObject).
     *
     * @ORM\Column(nullable=true)
     * @Assert\Url
     * @Iri("https://schema.org/image")
     */
    private $image;

    public function __construct()
    {
        $this->foods = new ArrayCollection();
    }

    public function addFood(FoodBasket $foodBasket)
    {
        $this->foods[] = $foodBasket;

        return $this;
    }

    public function removeFood(FoodBasket $foodBasket)
    {
        $this->foods->removeElement($foodBasket);
    }

    public function getFoods()
    {
        return $this->foods;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
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
