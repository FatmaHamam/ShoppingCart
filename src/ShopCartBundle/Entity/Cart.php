<?php

namespace ShopCartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Cart
 *
 * @ORM\Table(name="cart", indexes={@ORM\Index(name="custid", columns={"custid"})})
 * @ORM\Entity
 */
class Cart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="totalprice", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalprice;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100, nullable=true)
     */
    private $type;

    /**
     * @var \Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="custid", referencedColumnName="Customerid")
     * })
     */
    protected $custid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Items", inversedBy="cartid")
     * @ORM\JoinTable(name="cartitems",
     *   joinColumns={
     *     @ORM\JoinColumn(name="cartid", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="itemid", referencedColumnName="id")
     *   }
     * )
     */
    private $itemid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->itemid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }
    /**
     * @ORM\OneToMany(targetEntity="CartItems", mappedBy="cart", cascade={"all"})
     * */
    protected $po;
     public function __construct()
    {
        $this->po = new \Doctrine\Common\Collections\ArrayCollection();
    }

    protected $item;

    public function __construct()
    {
        $this->item = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Cart
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set totalprice
     *
     * @param string $totalprice
     *
     * @return Cart
     */
    public function setTotalprice($totalprice)
    {
        $this->totalprice = $totalprice;

        return $this;
    }

    /**
     * Get totalprice
     *
     * @return string
     */
    public function getTotalprice()
    {
        return $this->totalprice;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Cart
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set custid
     *
     * @param \ShopCartBundle\Entity\Customers $custid
     *
     * @return Cart
     */
    public function setCustid(\ShopCartBundle\Entity\Customers $custid = null)
    {
        $this->custid = $custid;

        return $this;
    }

    /**
     * Get custid
     *
     * @return \ShopCartBundle\Entity\Customers
     */
    public function getCustid()
    {
        return $this->custid;
    }

    /**
     * Add itemid
     *
     * @param \ShopCartBundle\Entity\Items $itemid
     *
     * @return Cart
     */
    public function addItemid(\ShopCartBundle\Entity\Items $itemid)
    {
        $this->itemid[] = $itemid;

        return $this;
    }

    /**
     * Remove itemid
     *
     * @param \ShopCartBundle\Entity\Items $itemid
     */
    public function removeItemid(\ShopCartBundle\Entity\Items $itemid)
    {
        $this->itemid->removeElement($itemid);
    }

    /**
     * Get itemid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemid()
    {
        return $this->itemid;
    }

    public function getItem()
    {
        $itemss = new ArrayCollection();
        
        foreach($this->po as $p)
        {
            $items[] = $p->getItem();
        }

        return $products;
    }

    public function setItem($items)
    {
        foreach($items as $i)
        {
            $po = new ProductOrder();

            $po->setCart($this);
            $po->setItem($i);

            $this->addPo($po);
        }

    }
}
