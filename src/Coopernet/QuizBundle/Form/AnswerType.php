<?php

namespace Coopernet\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType {
  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('title', TextType::class);
      /*
       * Rappel :
       ** - 1er argument : nom du champ, ici « categories », car c'est le nom de l'attribut
       ** - 2e argument : type du champ, ici « CollectionType » qui est une liste de quelque chose
       ** - 3e argument : tableau d'options du champ

      ->add('answers', CollectionType::class, array(
        'entry_type' => QuestionAnswerType::class,
        'required' => FALSE,
        'allow_add' => TRUE,
        'allow_delete' => TRUE
      ))*/
     // ->add('save', SubmitType::class);
  }

  /**
   * {@inheritdoc}
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Coopernet\QuizBundle\Entity\Answer'
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function getBlockPrefix() {
    return 'coopernet_quizbundle_answer';
  }


}
