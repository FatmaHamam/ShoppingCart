<?php

namespace ShopCartBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CartType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('totalprice')
            ->add('type')
            ->add('custid','integer')
            ->add('itemid', 'entity', array(
                'class' => 'ShopCartBundle\Entity\Items',
                'property' => 'id',
                'multiple' => true,
                'expanded' => true
              ))
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ShopCartBundle\Entity\Cart'
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'hopCartBundle\Entity\Cart' ,
            'em'         => '' ,
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'shopcartbundle_cart';
    }
    // public function __toString() {
    //     return $this->name;
    // }
}
