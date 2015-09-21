<?php

namespace ShopCartBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopCartBundle\Entity\Cart;
use ShopCartBundle\Form\CartType;
use ShopCartBundle\Entity\Items;
use ShopCartBundle\Form\ItemType;
use ShopCartBundle\Entity\CartItems;
use ShopCartBundle\Form\CartItemsType;

/**
 * Cart controller.
 *
 * @Route("/cart")
 */
class CartController extends Controller
{

    /**
     * Lists all Cart entities.
     *
     * @Route("/", name="cart")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShopCartBundle:Cart')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Cart entity.
     *
     * @Route("/", name="cart_create")
     * @Method("POST")
     * @Template("ShopCartBundle:Cart:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cart();
        $form = $this->createForm(new CartType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->render('ShopCartBundle:Cart:show.html.twig', $build);
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to create a new Cart entity.
     *
     * @Route("/new", name="cart_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new Cart();
        $form   = $this->createForm(new CartType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        // $em = $this->getDoctrine()->getEntityManager();

        // $item = $em->getRepository('ShopCartBundle:Items')->find($id);
        // $cart = $em->getRepository('ShopCartBundle:Cart')->find($id);

        // $cart->addItemid($item);
        // $cart->persist($item);
        // $em->flush();
    }

// Add Item to Cart
    public function addAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $item = $em->getRepository('ShopCartBundle:Items')->find($id);
        $cart = $em->getRepository('ShopCartBundle:Cart')->find($id);

        $cart->addItemid($item);

        $em->flush();
    }

    /**
     * Finds and displays a Cart entity.
     *
     * @Route("/{id}", name="cart_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $entity = $this->getDoctrine()->getRepository('ShopCartBundle:Cart')->find($id);

        if (!entity) {
            throw $this->createNotFoundException('Unable to find Cart entity.');
        }

        // $build['cart'] = $carts;
        // return $this->render('ShopCartBundle:Cart:index.html.twig', $build);

         $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    public function listAction()
    {
        $carts = $this->getDoctrine()->getEntityManager()
            ->createQuery('SELECT partial u.{id,description,totalprice,type} FROM ShopCartBundle:Cart u')
            ->getResult()
        ;
        $build['carts'] = $carts;
        return $this->render('ShopCartBundle:Cart:list.html.twig', $build);
        return array('carts' => $carts);
    }

    /**
     * Displays a form to edit an existing Cart entity.
     *
     * @Route("/{id}/edit", name="cart_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShopCartBundle:Cart')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cart entity.');
        }

        $editForm = $this->createForm(new CartType(), $entity, array('em'=> $em));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Cart entity.
    *
    * @param Cart $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cart $entity)
    {
        $form = $this->createForm(new CartType(), $entity, array(
            'action' => $this->generateUrl('cart_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cart entity.
     *
     * @Route("/{id}", name="cart_update")
     * @Method("PUT")
     * @Template("ShopCartBundle:Cart:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShopCartBundle:Cart')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cart entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CartType(), $entity);
        $previous = $entity->getPo();
        $previous = $previous->toArray();

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        foreach($previous as $c)
        {
            $entity->removePo($c);
        }

        if($editForm->isValid())
        {
            $em->persist($entity);
            $em->flush();

             return $this->render('ShopCartBundle:Cart:edit.html.twig', $build);

        }


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Cart entity.
     *
     * @Route("/{id}", name="cart_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShopCartBundle:Cart')->find($id);
        if (!$entity) {
          throw $this->createNotFoundException(
                  'No items found for id ' . $id
            );
        }

        $form = $this->createFormBuilder($entity)
                ->add('delete', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
          $em->remove($entity);
          $em->flush();
          return new Response('Cart deleted successfully');
        }
        
        $build['form'] = $form->createView();
        return $this->render('ShopCartBundle:Cart:new.html.twig', $build);
    }

    /**
     * Creates a form to delete a Cart entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */

    // Delete item from cart
    private function deleteitemAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $item = $em->getRepository('ShopCartBundle:Items')->find($id);
        $cart = $em->getRepository('ShopCartBundle:Cart')->find($id);

        $cart->removeItemid($item);

        $em->flush();
        
    }

    public function EmptyCartAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $qry = $em->createQuery('Delete FROM ShopCartBundle\Entity\Cart 
                WHERE id ='
        )->setParameter('id', $id);
        $carts = $qry->getResult();
        $build['carts'] = $carts;
        return $this->render('ShopCartBundle:Cart:list.html.twig', $build);
        return array('carts' => $carts);
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array( 'id' => $id ))
                        ->add('id' , 'hidden')
                        ->getForm();
    }

}
