<?php

namespace Coopernet\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Coopernet\QuizBundle\Repository\CategoryRepository")
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

  /**
   * @ORM\ManyToMany(targetEntity="Coopernet\QuizBundle\Entity\Quiz", cascade={"persist"})
   */
  private $quizs;

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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quizs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add quiz
     *
     * @param \Coopernet\QuizBundle\Entity\Quiz $quiz
     *
     * @return Category
     */
    public function addQuiz(\Coopernet\QuizBundle\Entity\Quiz $quiz)
    {
        $this->quizs[] = $quiz;

        return $this;
    }

    /**
     * Remove quiz
     *
     * @param \Coopernet\QuizBundle\Entity\Quiz $quiz
     */
    public function removeQuiz(\Coopernet\QuizBundle\Entity\Quiz $quiz)
    {
        $this->quizs->removeElement($quiz);
    }

    /**
     * Get quizs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuizs()
    {
        return $this->quizs;
    }
}
