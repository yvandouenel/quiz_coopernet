<?php
// src/Coopernet/QuizBundle/DataFixtures/ORM/LoadQuiz.php


namespace Coopernet\QuizBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Coopernet\QuizBundle\Entity\Quiz;


class LoadQuiz implements FixtureInterface

{

  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

  public function load(ObjectManager $manager)

  {

    // Liste des noms de quiz à ajouter

    $names = array(
      'Commandes symfony depuis la console',
      "Doctrine"
    );

    foreach ($names as $name) {
      // On crée le quiz
      $quiz = new Quiz();
      $quiz->setName($name);
      // On la persiste
      $manager->persist($quiz);
    }

    // On déclenche l'enregistrement de tous les quiz
    $manager->flush();

  }

}