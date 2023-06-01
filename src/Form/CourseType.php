<?php

namespace App\Form;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Teacher;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            //->add('teacher', TextType::class)
            ->add('startday', DateType::class, ['widget' => 'single_text'])
            ->add('endday', DateType::class, ['widget' => 'single_text'])
            ->add('des',TextType::class)
            ->add('price',NumberType::class)
            ->add('teacher', EntityType::class, [
                'class' => Teacher::class,
                'choice_label' => 'vietnamname', // Assuming Teacher entity has a 'name' property
                'placeholder' => 'Select a teacher',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
            'property_path' => 'teacher', // Assuming the property name in the Course entity is 'teacher'
        ]);
    }
}
