<?php

namespace Coopernet\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="Coopernet\QuizBundle\Repository\AnswerRepository")
 */
class Answer {
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
   * @ORM\OneToMany(targetEntity="Coopernet\QuizBundle\Entity\QuestionAnswer", mappedBy="answer")
   */
  private $answers;


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
   * @return Answer
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
    $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Add answer
   *
   * @param \Coopernet\QuizBundle\Entity\QuestionAnswer $answer
   *
   * @return Answer
   */
  public function addAnswer(\Coopernet\QuizBundle\Entity\QuestionAnswer $answer) {
    $this->answers[] = $answer;

    // On lie QuestionAnswer à la réponse
    $answer->setAnswer($this);

    return $this;
  }

  /**
   * Remove answer
   *
   * @param \Coopernet\QuizBundle\Entity\QuestionAnswer $answer
   */
  public function removeAnswer(\Coopernet\QuizBundle\Entity\QuestionAnswer $answer) {
    $this->answers->removeElement($answer);
  }

  /**
   * Get answers
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getAnswers() {
    return $this->answers;
  }
}
