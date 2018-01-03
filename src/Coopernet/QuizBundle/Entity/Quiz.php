<?php

namespace Coopernet\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Table(name="quiz")
 * @ORM\Entity(repositoryClass="Coopernet\QuizBundle\Repository\QuizRepository")
 */
class Quiz {
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;

  /**
   * @ORM\ManyToMany(targetEntity="Coopernet\QuizBundle\Entity\Question", inversedBy="quizs")
   * @ORM\JoinColumn(nullable=false)
   */
  private $questions;

  /**
   * Get id
   *
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   *
   * @return Quiz
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Constructor
   */
  public function __construct() {
    $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Add question
   *
   * @param \Coopernet\QuizBundle\Entity\Question $question
   *
   * @return Quiz
   */
  public function addQuestion(\Coopernet\QuizBundle\Entity\Question $question) {
    $this->questions[] = $question;

    // On lie la question à ce quiz
    $question->addQuiz($this);

    return $this;
  }

  /**
   * Remove question
   *
   * @param \Coopernet\QuizBundle\Entity\Question $question
   */
  public function removeQuestion(\Coopernet\QuizBundle\Entity\Question $question) {
    $this->questions->removeElement($question);
  }

  /**
   * Get questions
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getQuestions() {
    return $this->questions;
  }
}
