<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('publishedAt')
            ->add('picture')
            ->add('permalink')
            ->add('categories', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => true])
            ->add('user',  EntityType::class, [
                'class' => User::class,
                'choice_label' => 'pseudo'])
            ->add('valid')
        ;
    }
//            
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
