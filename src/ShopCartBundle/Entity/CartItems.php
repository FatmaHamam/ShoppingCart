<?php

namespace ShopCartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItems
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CartItems
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
     * @var \stdClass
     *
     * @ORM\Column(name="cart", type="object")
     */
    private $cart;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="items", type="object")
     */
    private $items;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cart
     *
     * @param \stdClass $cart
     *
     * @return CartItems
     */
    public function setCart($cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \stdClass
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set items
     *
     * @param \stdClass $items
     *
     * @return CartItems
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return \stdClass
     */
    public function getItems()
    {
        return $this->items;
    }
}

