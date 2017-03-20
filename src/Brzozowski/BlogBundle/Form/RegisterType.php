<?php

namespace Brzozowski\BlogBundle\Form;

use Brzozowski\BlogBundle\Entity\Register;

use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Imię i nazwisko'
            ))
            ->add('email', EmailType::class, array(
                'label' => 'E-mail'
            ))
            ->add('sex', ChoiceType::class, array(
                'label' => 'Płeć',
                'choices' => array(
                    'Mężczyzna' => 'm',
                    'Kobieta' => 'f'
                ),
                'expanded' => true,
            ))
            ->add('birthdate', BirthdayType::class, array(
                'label' => 'Data urodzenia',
                'empty_data' => NULL,
                'placeholder' => '--'
            ))
            ->add('country', CountryType::class, array(
                'label' => 'Kraj',
                'empty_data' => NULL,
                'placeholder' => '--'
            ))
            ->add('course', ChoiceType::class, array(
                'label' => 'Kurs',
                'choices' => array(
                    'Kurs podstawowy' => 'basic',
                    'Analiza techniczna' => 'at',
                    'Analiza fundamentalna' => 'af',
                    'Kurs zaawansowany' => 'master'
                ),
                'empty_data' => NULL,
                'placeholder' => '--'
            ))
            /*
            ->add('invest', ChoiceType::class, [
                'choices' => [
                    new Category('Akcje'),
                    new Category('Obligacje'),
                    new Category('Forex'),
                    new Category('ETF'),
                ],
                'expanded' => true,
                'multiple' => true
            ])
            */

            ->add('invest', ChoiceType::class, array(
                'label' => 'Inwestycje',
                'choices' => array(
                    'Akcje' => 'a',
                    'Obligacje' => 'o',
                    'Forex' => 'f',
                    'ETF' => 'etf'
                ),
                'expanded' => true,
                'multiple' => true
            ))

            ->add('comments', TextareaType::class, array(
                'label' => 'Komentarz'
            ))
            ->add('payment_file', FileType::class, array(
                'label' => 'Potwierdzenie zapłaty'
            ))
            ->add('rules', CheckboxType::class, array(
                'label' => 'Akceptuję regulamin szkolenia',
//              'mapped' => false
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Zapisz'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Brzozowski\BlogBundle\Entity\Register'
        ));
    }

    public function getBlockPrefix()
    {
        return 'brzozowski_blog_bundle_task';
    }
}
