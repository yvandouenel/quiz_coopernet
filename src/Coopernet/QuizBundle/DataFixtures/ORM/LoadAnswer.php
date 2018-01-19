<?php
// src/Coopernet/QuizBundle/DataFixtures/ORM/LoadAnswer.php


namespace Coopernet\QuizBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Coopernet\QuizBundle\Entity\Answer;


class LoadAnswer implements FixtureInterface

{

  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

  public function load(ObjectManager $manager)

  {

    // Liste des réponses à ajouter

    $titles = array(
      'php bin/console doctrine:generate:entity',
      'thc bin/console doctrine:generate:entity',
      '$this->getDoctrine()->getManager();',
      'php bin/console doctrine:schema:update --force'
    );

    foreach ($titles as $title) {
      // On crée les réponses
      $answer = new Answer();
      $answer->setTitle($title);
      // On la persiste
      $manager->persist($answer);
    }

    // On déclenche l'enregistrement de toutes les réponses
    $manager->flush();

  }

}