<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dunglas\ApiBundle\Annotation\Iri;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


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
     * @Groups({"basket"})
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var FoodBasket
     * @Groups({"basket"})
     *
     * @ORM\OneToMany(targetEntity="FoodBasket", mappedBy="basket", cascade={"all"})
     */
    private $foodBaskets;

    /**
     * @var string An image of the item. This can be a [URL](http://schema.org/URL) or a fully described [ImageObject](http://schema.org/ImageObject).
     * @Groups({"basket"})
     *
     * @ORM\Column(nullable=true)
     * @Assert\Url
     * @Iri("https://schema.org/image")
     */
    private $image;

    /**
     * @var User\User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="basket")
     */
    private $user;

    public function __construct()
    {
        $this->foodBaskets = new ArrayCollection();
    }

    public function addFoodBasket(FoodBasket $foodBasket)
    {
        $foodBasket->setBasket($this);
        $this->foodBaskets[] = $foodBasket;

        return $this;
    }

    public function removeFoodBasket(FoodBasket $foodBasket)
    {
        $foodBasket->setBasket(null);
        $this->foodBaskets->removeElement($foodBasket);
    }

    public function getFoodBaskets()
    {
        return $this->foodBaskets;
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

    /**
     * @return User\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User\User $user
     *
     * @return $this
     */
    public function setUser(User\User $user)
    {
        $this->user = $user;

        return $this;
    }

}
