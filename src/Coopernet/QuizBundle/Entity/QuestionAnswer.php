<?php

namespace Coopernet\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionAnswer
 *
 * @ORM\Table(name="question_answer")
 * @ORM\Entity(repositoryClass="Coopernet\QuizBundle\Repository\QuestionAnswerRepository")
 */
class QuestionAnswer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="good_answer", type="boolean")
     */
    private $goodAnswer;

  /**
   * @ORM\ManyToOne(targetEntity="Coopernet\QuizBundle\Entity\Answer", inversedBy="answers")
   * @ORM\JoinColumn(nullable=false)
   */
  private $answer;
  /**
   * @ORM\ManyToOne(targetEntity="Coopernet\QuizBundle\Entity\Question", inversedBy="questions")
   * @ORM\JoinColumn(nullable=false)
   */
  private $question;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set goodAnswer
     *
     * @param boolean $goodAnswer
     *
     * @return QuestionAnswer
     */
    public function setGoodAnswer($goodAnswer)
    {
        $this->goodAnswer = $goodAnswer;

        return $this;
    }

    /**
     * Get goodAnswer
     *
     * @return bool
     */
    public function getGoodAnswer()
    {
        return $this->goodAnswer;
    }

    /**
     * Set answer
     *
     * @param \Coopernet\QuizBundle\Entity\Answer $answer
     *
     * @return QuestionAnswer
     */
    public function setAnswer(\Coopernet\QuizBundle\Entity\Answer $answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \Coopernet\QuizBundle\Entity\Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set question
     *
     * @param \Coopernet\QuizBundle\Entity\Question $question
     *
     * @return QuestionAnswer
     */
    public function setQuestion(\Coopernet\QuizBundle\Entity\Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Coopernet\QuizBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
