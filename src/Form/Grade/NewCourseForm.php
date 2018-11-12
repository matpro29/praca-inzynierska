<?php

namespace App\Form\Grade;

use App\Entity\Grade;
use App\Entity\UserCourseGrade;
use App\Repository\GradeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewCourseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('grade', EntityType::class, [
                'choice_label' => 'grade',
                'class' => Grade::class,
                'label' => 'Ocena: ',
                'query_builder' => function (GradeRepository $gradeRepository) {
                    return $gradeRepository->findAllQB();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserCourseGrade::class
        ]);
    }
}