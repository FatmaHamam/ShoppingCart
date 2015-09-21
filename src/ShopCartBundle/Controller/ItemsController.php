<?php

namespace ShopCartBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopCartBundle\Entity\Items;
use ShopCartBundle\Form\ItemsType;

/**
 * Items controller.
 *
 * @Route("/items")
 */
class ItemsController extends Controller
{

    /**
     * Lists all Items entities.
     *
     * @Route("/", name="items")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ShopCartBundle:Items')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Items entity.
     *
     * @Route("/", name="items_create")
     * @Method("POST")
     * @Template("ShopCartBundle:Items:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Items();
        $form = $this->createFormBuilder($entity)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('type', 'choice', array(
            'choices'  => array('N' => 'Normal', 'S' => 'Sale'),
            'required' => true,
            ))
            ->add('price', 'money')
            ->add('save', 'submit')
            ->getForm();

         $form->handleRequest($request);    
         if ($form->isValid()) {
           $em = $this->getDoctrine()->getManager();
           $em->persist($entity);
           $em->flush();
           return new Response('News added successfuly');
         }
    
         $build['form'] = $form->createView();
         return $this->render('ShopCartBundle:Items:new.html.twig', $build);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to create a new Items entity.
     *
     * @Route("/new", name="items_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Items();
        $form   = $this->createForm(new ItemsType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Items entity.
     *
     * @Route("/{id}", name="items_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShopCartBundle:Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Items entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Items entity.
     *
     * @Route("/{id}/edit", name="items_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShopCartBundle:Items')->find($id);
        if (!$entity) {
          throw $this->createNotFoundException(
                  'No items found for id ' . $id
          );
    }
    
    $form = $this->createFormBuilder($entity)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('type', 'text')
            ->add('price', 'number')
            ->add('save', 'submit')
            ->getForm();

    $form->handleRequest($request);
 
    if ($form->isValid()) {
        $em->flush();
        return new Response('Items updated successfully');
    }
    
    $build['form'] = $form->createView();

    return $this->render('ShopCartBundle:Items:edit.html.twig', $build);
    }

    
    /**
     * Edits an existing Items entity.
     *
     * @Route("/{id}", name="items_update")
     * @Method("PUT")
     * @Template("ShopCartBundle:Items:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ShopCartBundle:Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Items entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ItemsType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('items_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Items entity.
     *
     * @Route("/{id}", name="items_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShopCartBundle:Items')->find($id);
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
          return new Response('Items deleted successfully');
        }
        
        $build['form'] = $form->createView();
        return $this->render('ShopCartBundle:Items:new.html.twig', $build);
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
