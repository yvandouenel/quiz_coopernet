<?php

namespace Coopernet\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="Coopernet\QuizBundle\Repository\QuestionRepository")
 */
class Question {
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
   * @ORM\Column(name="title", type="string", length=255)
   */
  private $title;

  /**
   * @ORM\OneToMany(targetEntity="Coopernet\QuizBundle\Entity\QuestionAnswer", mappedBy="question")
   */
  private $questions;

  /**
   * @ORM\ManyToMany(targetEntity="Coopernet\QuizBundle\Entity\Quiz", mappedBy="questions")
   */
  private $quizs;

  /**
   * Get id
   *
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set title
   *
   * @param string $title
   *
   * @return Question
   */
  public function setTitle($title) {
    $this->title = $title;

    return $this;
  }

  /**
   * Get title
   *
   * @return string
   */
  public function getTitle() {
    return $this->title;
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
   * @param \Coopernet\QuizBundle\Entity\QuestionAnswer $question
   *
   * @return Question
   */
  public function addQuestion(\Coopernet\QuizBundle\Entity\QuestionAnswer $question) {
    $this->questions[] = $question;

    // On lie QuestionAnswer à la question
    $question->setQuestion($this);

    return $this;
  }

  /**
   * Remove question
   *
   * @param \Coopernet\QuizBundle\Entity\QuestionAnswer $question
   */
  public function removeQuestion(\Coopernet\QuizBundle\Entity\QuestionAnswer $question) {
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

  /**
   * Add quiz
   *
   * @param \Coopernet\QuizBundle\Entity\Quiz $quiz
   *
   * @return Question
   */
  public function addQuiz(\Coopernet\QuizBundle\Entity\Quiz $quiz) {
    $this->quizs[] = $quiz;

    return $this;
  }

  /**
   * Remove quiz
   *
   * @param \Coopernet\QuizBundle\Entity\Quiz $quiz
   */
  public function removeQuiz(\Coopernet\QuizBundle\Entity\Quiz $quiz) {
    $this->quizs->removeElement($quiz);
  }

  /**
   * Get quizs
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getQuizs() {
    return $this->quizs;
  }
}
