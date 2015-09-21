<?php

namespace ShopCartBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopCartBundle\Entity\CartItems;
use ShopCartBundle\Entity\Cart;
use ShopCartBundle\Entity\Items;
use ShopCartBundle\Form\CartItemsType;
use ShopCartBundle\Form\CartType;
use ShopCartBundle\Form\ItemsType;

/**
 * CartItems controller.
 *
 * @Route("/cartitems")
 */
class CartItemsController extends Controller
{

    /**
     * Lists all CartItems entities.
     *
     * @Route("/", name="cartitems")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShopCartBundle:CartItems')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CartItems entity.
     *
     * @Route("/", name="cartitems_create")
     * @Method("POST")
     * @Template("ShopCartBundle:CartItems:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CartItems();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cartitems_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CartItems entity.
     *
     * @param CartItems $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CartItems $entity)
    {
        $form = $this->createForm(new CartItemsType(), $entity, array(
            'action' => $this->generateUrl('cartitems_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CartItems entity.
     *
     * @Route("/new", name="cartitems_new")
     * @Method("GET")
     * @Template()
     */
    // public function addAction($id)
    // {
    //     $em = $this->getDoctrine()->getEntityManager();

    //     $item = $em->getRepository('ShopCartBundle:Items')->find($id);
    //     $cart = $em->getRepository('ShopCartBundle:Cart')->find($id);

    //     $cart->addItemid($item);

    //     $em->flush();
    // }

    /**
     * Finds and displays a CartItems entity.
     *
     * @Route("/{id}", name="cartitems_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction()
    {
         $em = $this->getDoctrine()->getManager();

        // $entity = $em->getRepository('ShopCartBundle:CartItems')->find($id);

        // if (!$entity) {
        //     throw $this->createNotFoundException('Unable to find CartItems entity.');
        // }

        // $deleteForm = $this->createDeleteForm($id);

        // return array(
        //     'entity'      => $entity,
        //     'delete_form' => $deleteForm->createView(),
        // );
    //     $dql = '
    //     SELECT   name,price
    //     FROM     ShopCartBundle\Entity\Items a
    //     WHERE    a.id=
    //     (SELECT itemid FROM ShopCartBundle\Entity\Cart
    //     WHERE id=1)';

    //     $carts = $em->createQuery($dql)->getResult();

    //     foreach ($carts as $cart) {
    //         echo $cart->getType() . PHP_EOL;

    //         foreach ($cart->getitems() as $item) {
    //             echo sprintf("\t#%d - %-20s (%s) %s\n", 
    //                 $item->getName(),
    //                 $item->getType()
    //             );
    //         }   
    // }
    }

    /**
     * Displays a form to edit an existing CartItems entity.
     *
     * @Route("/{id}/edit", name="cartitems_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShopCartBundle:CartItems')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CartItems entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a CartItems entity.
    *
    * @param CartItems $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CartItems $entity)
    {
        $form = $this->createForm(new CartItemsType(), $entity, array(
            'action' => $this->generateUrl('cartitems_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CartItems entity.
     *
     * @Route("/{id}", name="cartitems_update")
     * @Method("PUT")
     * @Template("ShopCartBundle:CartItems:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShopCartBundle:CartItems')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CartItems entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cartitems_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CartItems entity.
     *
     * @Route("/{id}", name="cartitems_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ShopCartBundle:CartItems')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CartItems entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cartitems'));
    }

    /**
     * Creates a form to delete a CartItems entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cartitems_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
