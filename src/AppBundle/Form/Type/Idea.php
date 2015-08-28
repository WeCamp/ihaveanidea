<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Idea extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add(
                'youtube-flag',
                'checkbox',
                [
                    'label' => 'Show Youtube Video',
                    'required' => false,
                ]
            )
            ->add(
                'youtube-value',
                'text',
                [
                    'label' => 'Link to Youtube Video',
                    'required' => false,
                ]
            )
            ->add('save', 'submit', array('label' => 'Post an Idea'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'idea';
    }
}
