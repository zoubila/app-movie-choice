<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class WillRefinerType extends AbstractType
{
    private function getGenreChoices(): array
    {
        return [
            'Action' => 28,
            'Aventure' => 12,
            'Animation' => 16,
            'Comédie' => 35,
            'Crime' => 80,
            'Documentaire' => 99,
            'Drame' => 18,
            'Familial' => 10751,
            'Fantastique' => 14,
            'Histoire' => 36,
            'Horreur' => 27,
            'Musique' => 10402,
            'Mystère' => 9648,
            'Romance' => 10749,
            'Science-Fiction' => 878,
            'Téléfilm' => 10770,
            'Thriller' => 53,
            'Guerre' => 10752,
            'Western' => 37,
        ];
    }
    private function getCertificationChoices(): array
    {
        return [
            'Tout public' => 'TP',
            'Interdit au moins de 12ans' => '12',
            'Interdit au moins de 16ans' => '16',
            'Interdit au moins de 18ans' => '18',
        ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('language', ChoiceType::class, [
//                'choices' => ['Français' => 'fr', 'English' => 'en'],
//                'label' => 'Langue des résultats',
//                'required' => false,
//            ])
//            ->add('region', TextType::class, [
//                'label' => 'Région',
//                'required' => false,
//            ])
//            ->add('include_adult', CheckboxType::class, [
//                'label' => 'Inclure les contenus adultes',
//                'required' => false,
//            ])
//            ->add('certification', ChoiceType::class, [
//                'choices' => $this->getCertificationChoices(),
//                'label' => 'Certification',
//                'required' => false,
//            ])
//            ->add('include_video', CheckboxType::class, [
//                'label' => 'Inclure les vidéos',
//                'required' => false,
//            ])
//            ->add('certification_country', CountryType::class, [
//                'label' => 'Pays de certification',
//                'required' => false,
//            ])
//            ->add('certification_lte', TextType::class, [
//                'label' => 'Certification maximale',
//                'required' => false,
//            ])
//            ->add('primary_release_year', IntegerType::class, [
//                'label' => 'Année de sortie principale',
//                'required' => false,
//            ])
//            ->add('sort_by', ChoiceType::class, [
//                'choices' => [
//                    'Popularité descendante' => 'popularity.desc',
//                    'Popularité ascendante' => 'popularity.asc',
//                    'Date de sortie récente' => 'release_date.desc',
//                    'Date de sortie ancienne' => 'release_date.asc',
//                ],
//                'label' => 'Trier par',
//                'required' => false,
//            ])
//            ->add('vote_average_gte', NumberType::class, [
//                'label' => 'Note minimale',
//                'required' => false,
//                'scale' => 1,
//            ])
//            ->add('with_genres', ChoiceType::class, [
//                'choices' => $this->getGenreChoices(),
//                'label' => 'Genres',
//                'required' => false,
//                'multiple' => true,
//                'expanded' => false,
//                'attr' => ['class' => 'tom-select']
//            ])
            ->add('with_genres', ChoiceType::class, [
                'choices' => $this->getGenreChoices(),
                'label' => 'Genres',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'genre-choice-group'],
                'label_attr' => ['class' => 'category-label']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Propose moi un film',
                'attr' => [
                    'class' => 'submit-form-button',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}