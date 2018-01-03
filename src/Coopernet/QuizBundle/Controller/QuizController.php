<?php
namespace Coopernet\QuizBundle\Controller;

use Coopernet\QuizBundle\Entity\QuestionAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{
  public function homeAction(Request $request)
  {
    // get all categories
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository("CoopernetQuizBundle:Category")->findAll();

    $content = $this->get('templating')->render('CoopernetQuizBundle:Quiz:home.html.twig', array("categories"=>$categories));
    return new Response($content);
  }

  public function viewcategoryAction($id) {
    // get the category
    $em = $this->getDoctrine()->getManager();
    $category = $em->getRepository("CoopernetQuizBundle:Category")->find($id);

    // get quizes from this category
    $quizs = $category->getQuizs();

    $content = $this
      ->get('templating')
      ->render('CoopernetQuizBundle:Quiz:viewcategory.html.twig',
        array(
          "category" => $category,
          "quizs" => $quizs
        )
      );
    return new Response($content);
  }

  public function viewquizAction($id) {
    // get the category
    $em = $this->getDoctrine()->getManager();

    // get question and answer
    $questions_answers = $em->getRepository("CoopernetQuizBundle:QuestionAnswer")->getAllQAFromSpecficQuiz($id);

    $quiz = $em->getRepository("CoopernetQuizBundle:Quiz")->find($id);


    $content = $this
      ->get('templating')
      ->render('CoopernetQuizBundle:Quiz:viewquiz.html.twig',
        array(
          "quiz" => $quiz,
          "questions_answers" => $questions_answers
        )
      );
    return new Response($content);
  }

  public function createlinkAction(Request $request)
  {
    // récupérer la catégorie qui a pour nom : "SYMFONY"
    $em = $this->getDoctrine()->getManager();
    $category1 = $em->getRepository("CoopernetQuizBundle:Category")->findOneBy(array('name'=>'SYMFONY'));

    // Ajouter à cette catégorie le quiz qui a pour nom "Commandes symfony depuis la console"
    $quiz1 = $em->getRepository("CoopernetQuizBundle:Quiz")->findOneBy(array('name'=>'Commandes symfony depuis la console'));
    $category1->addQuiz($quiz1);

    // Ajouter à cette catégorie le quiz qui a pour nom "Doctrine"
    $quiz2 = $em->getRepository("CoopernetQuizBundle:Quiz")->findOneBy(array('name'=>'Doctrine'));
    $category1->addQuiz($quiz2);


    // récupérer la question qui a pour title "Commande pour ajouter une entité ?"
    $question1 = $em->getRepository("CoopernetQuizBundle:Question")->findOneBy(array('title'=>'Commande pour ajouter une entité ?'));
    //(cf https://docs.google.com/document/d/1-J4DPP_VPn_2_GeCOcQfnC_1YsKVJix6DMdg2F_47OM/edit#bookmark=id.oqnbzbmlkvxe)

    // récupérer la question qui a pour title "Création d'un entity manager ?"
    $question2 = $em->getRepository("CoopernetQuizBundle:Question")->findOneBy(array('title'=>"Création d'un entity manager ?"));



    // récupérer la réponse qui a pour title "php bin/console doctrine:generate:entity"
    $answer1 = $em->getRepository("CoopernetQuizBundle:Answer")->findOneBy(array('title'=>'php bin/console doctrine:generate:entity'));
    $answer2 = $em->getRepository("CoopernetQuizBundle:Answer")->findOneBy(array('title'=>'thc bin/console doctrine:generate:entity'));

    // récupérer la réponse qui a pour title "$this->getDoctrine()->getManager();"
    $answer3 = $em->getRepository("CoopernetQuizBundle:Answer")->findOneBy(array('title'=>'$this->getDoctrine()->getManager();'));

    // ajout de la question à la réponse
    $question_answer1 = new QuestionAnswer();
    $question_answer1->setGoodAnswer(true);
    $question1->addQuestion($question_answer1);
    $answer1->addAnswer($question_answer1);

    // ajout de la question à la réponse
    $question_answer2 = new QuestionAnswer();
    $question_answer2->setGoodAnswer(false);
    $question1->addQuestion($question_answer2);
    $answer2->addAnswer($question_answer2);

    // ajout de la question à la réponse
    $question_answer3 = new QuestionAnswer();
    $question_answer3->setGoodAnswer(true);
    $question2->addQuestion($question_answer3);
    $answer3->addAnswer($question_answer3);

    // Ajout des questions au quiz
    $quiz1->addQuestion($question1);
    $quiz2->addQuestion($question2);

    $em->persist($question_answer1);
    $em->persist($question_answer2);
    $em->persist($question_answer3);

    // entrer en base de données
    $em->flush();

    $content = $this->get('templating')
      ->render('CoopernetQuizBundle:Quiz:createlinks.html.twig');
    return new Response($content);
  }
  public function viewAction(Request $request)
  {
    // On récupère notre paramètre tag
    $tag = $request->query->get('tag');
    /*return new Response(
      "Affichage de l'annonce d'id : ".$id.", avec le tag : ".$tag
    );*/

    $content = $this->get('templating')->render('CoopernetQuizBundle:Home:view.html.twig', array(
      "nom" => "Douënel",
      "prenom" => "Yvan",
      "tag" => $tag
    ));
    return new Response($content);
  }
}