<?php

namespace App\Form\Course;

use App\Entity\Course;
use App\Entity\Subject;
use App\Entity\User;
use App\Repository\SubjectRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NewAdminForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nazwa: ',
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Opis: ',
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => 'Hasło: '
                ),
                'second_options' =>  array(
                    'label' => 'Powtórz hasło: '
                )
            ))
            ->add('owner', EntityType::class, array(
                'choice_label' => 'ownerFormLabel',
                'class' => User::class,
                'label' => 'Właścicel: ',
                'query_builder' => function (UserRepository $userRepository) {
                    return $userRepository->findAllUsersByRole('ROLE_TEACHER');
                },
            ))
            ->add('subject', EntityType::class, array(
                'choice_label' => 'subjectName',
                'class' => Subject::class,
                'label' => 'Przedmiot: ',
                'query_builder' => function (SubjectRepository $subjectRepository) {
                    return $subjectRepository->findAllSubjects();
                },
            ))
            ->add('add', SubmitType::class, array(
                'label' => 'Zapisz'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
