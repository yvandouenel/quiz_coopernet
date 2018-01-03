<?php
// src/Coopernet/QuizBundle/DataFixtures/ORM/LoadQuestion.php


namespace Coopernet\QuizBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Coopernet\QuizBundle\Entity\Question;


class LoadQuestion implements FixtureInterface {

  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

  public function load(ObjectManager $manager) {
    // Liste des questions à ajouter
    $titles = array(
      'Commande pour ajouter une entité ?',
      "Création d'un entity manager ?"
    );

    foreach ($titles as $title) {
      // On crée la question
      $question = new Question();
      $question->setTitle($title);
      // On la persiste
      $manager->persist($question);
    }

    // On déclenche l'enregistrement de toutes les questions
    $manager->flush();

  }

}