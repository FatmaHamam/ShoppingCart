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
     *
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="po")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    private $cart;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="po")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
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

    public function __toString()
    {
        return (string)$this->prodcut;
    }
}

