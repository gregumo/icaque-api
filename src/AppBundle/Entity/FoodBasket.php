<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FoodBasket
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FoodBasket
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Basket", inversedBy="foods")
     * @ORM\JoinColumn(name="basket_id", referencedColumnName="id", nullable=false)
     */
    private $basket;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product\Food")
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id", nullable=false)
     */
    private $food;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $stock;


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
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * @param mixed $basket
     */
    public function setBasket($basket)
    {
        $this->basket = $basket;
    }

    /**
     * @return mixed
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * @param mixed $food
     */
    public function setFood($food)
    {
        $this->food = $food;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

}
