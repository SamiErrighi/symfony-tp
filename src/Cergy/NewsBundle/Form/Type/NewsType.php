<?php
/**
 * Created by PhpStorm.
 * User: sami
 * Date: 25/11/2014
 * Time: 14:52
 */

namespace Cergy\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'required'   => true,
                'max_length' => 100,
                'label'      => 'Titre'
            ])
            ->add('content', 'textarea', [
                'required' => true,
                'label' => 'Contenu'
            ])
        ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'Cergy\NewsBundle\Entity\News'
        ]);
    }


    /**
     * return the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return "news";
    }
} 