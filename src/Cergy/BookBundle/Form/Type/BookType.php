<?php
/**
 * Created by PhpStorm.
 * User: sami
 * Date: 27/11/2014
 * Time: 14:35
 */

namespace Cergy\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'required'   => true,
                'max_length' => 100,
                'label'      => 'Nom'
            ])
            ->add('description', 'textarea', [
                'required' => true
            ])
            ->add('price', 'text', [
                'required' => true
            ])
            ->add('category', 'entity', [
                'class' =>  'CergyBookBundle:Category',
                'property' => 'name'
            ])
            ->add('user', 'entity', [
                'class' =>  'CergyUserBundle:User',
                'property' => 'username'
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Cergy\BookBundle\Entity\Book'
        ]);
    }


    /**
     * return the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return "book";
    }
} 