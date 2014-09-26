<?php
/**
 * Created by PhpStorm.
 * User: ptring
 * Date: 26/09/2014
 * Time: 10:52
 */

namespace Gobelins\NewsBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'news_form';
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'required' => true,
                'label' => 'Title',
                'max_length' => 100
            ])
            ->add('content', 'textarea', [
               'label' => 'Contenu'
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Gobelins\NewsBundle\Entity\News'
        ]);
    }

}