<?php
namespace Coopernet\QuizBundle\Controller;

use Coopernet\QuizBundle\Entity\Answer;
use Coopernet\QuizBundle\Entity\Question;
use Coopernet\QuizBundle\Entity\QuestionAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* imports nécessaires à la création d'un formulaire */
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class QuizController extends Controller {
  public function homeAction(Request $request) {
    // get all categories
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository("CoopernetQuizBundle:Category")->findAll();

    $content = $this->get('templating')
      ->render('CoopernetQuizBundle:Quiz:home.html.twig', array("categories" => $categories));
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
    // get the entity manager
    $em = $this->getDoctrine()->getManager();

    // get question and answer
    $questions_answers = $em->getRepository("CoopernetQuizBundle:QuestionAnswer")
      ->getAllQAFromSpecficQuiz($id);
    //shuffle($questions_answers);

    $content = $this
      ->get('templating')
      ->render('CoopernetQuizBundle:Quiz:viewquiz.html.twig',
        array(
          "questions_answers" => $questions_answers
        )
      );
    return new Response($content);
  }

  public function addquizquestionAction($id, Request $request) {
    // get the entity manager
    $em = $this->getDoctrine()->getManager();
    $quiz = $em->getRepository("CoopernetQuizBundle:Quiz")->find($id);

    $question = new Question();
    // Le bundle a été pensé pour que l'on ajoute des questions au quiz et pas l'inverse
    // Donc $question->addQuiz($quiz); ne fonctionne pas
    $quiz->addQuestion($question);

    // Création du formulaire
    $formBuilder = $this->get('form.factory')
      ->createBuilder(FormType::class, $question);

    // Ajout des champs
    $formBuilder
      ->add('title', TextType::class)
      ->add('save', SubmitType::class);

    // Génération du fomulaire
    $form = $formBuilder->getForm();

    // Si la requête est en POST

    if ($request->isMethod('POST')) {
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $questiont contient les valeurs entrées dans le formulaire par le visiteur
      $form->handleRequest($request);
      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $question dans la base de données, par exemple
        $em = $this->getDoctrine()->getManager();
        $em->persist($question);
        $em->persist($quiz);
        $em->flush();
        $request->getSession()
          ->getFlashBag()
          ->add('notice', 'Question bien enregistrée.');
        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirectToRoute('coopernet_quiz_view_quiz', array('id' => $id));
      }
    }
    // À ce stade, le formulaire n'est pas valide car :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

    $content = $this
      ->get('templating')
      ->render('CoopernetQuizBundle:Quiz:addquestion.html.twig', array(
        'form' => $form->createView(),
        'quiz' => $quiz,
      ));
    return new Response($content);
  }
  public function viewquestionAction($id, Request $request) {
    // get the entity manager
    $em = $this->getDoctrine()->getManager();
    $question = $em->getRepository("CoopernetQuizBundle:Question")->find($id);
/*
    // ajout de la question à la réponse
    $question = new Question();
    $question_answer = new QuestionAnswer();
    $question->addQuestion($question_answer);
    $answer->addAnswer($question_answer1);
    // Création du formulaire
    $formBuilder = $this->get('form.factory')
      ->createBuilder(FormType::class, $answer);

    // Ajout des champs
    $formBuilder
      ->add('title', TextType::class)
      ->add('save', SubmitType::class);

    // Génération du fomulaire
    $form = $formBuilder->getForm();

    // Si la requête est en POST

    if ($request->isMethod('POST')) {
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $questiont contient les valeurs entrées dans le formulaire par le visiteur
      $form->handleRequest($request);
      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $question dans la base de données, par exemple
        $em = $this->getDoctrine()->getManager();
        $em->persist($answer);
        $em->persist($quiz);
        $em->flush();
        $request->getSession()
          ->getFlashBag()
          ->add('notice', 'Question bien enregistrée.');
        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirectToRoute('coopernet_quiz_view_quiz', array('id' => $id));
      }
    }
*/
    // get answers for this question
    $questions_answers = $em->getRepository("CoopernetQuizBundle:QuestionAnswer")
      ->getAllAnswerFromQuestion($id);

    $content = $this
      ->get('templating')
      ->render('CoopernetQuizBundle:Quiz:viewquestion.html.twig', array(
        'question' => $question,
        'questions_answers' =>  $questions_answers,
      ));
    return new Response($content);
  }

  public function createlinkAction(Request $request) {
    // récupérer la catégorie qui a pour nom : "SYMFONY"
    $em = $this->getDoctrine()->getManager();
    $category1 = $em->getRepository("CoopernetQuizBundle:Category")
      ->findOneBy(array('name' => 'SYMFONY'));

    // Ajouter à cette catégorie le quiz qui a pour nom "Commandes symfony depuis la console"
    $quiz1 = $em->getRepository("CoopernetQuizBundle:Quiz")
      ->findOneBy(array('name' => 'Commandes symfony depuis la console'));
    $category1->addQuiz($quiz1);

    // Ajouter à cette catégorie le quiz qui a pour nom "Doctrine"
    $quiz2 = $em->getRepository("CoopernetQuizBundle:Quiz")
      ->findOneBy(array('name' => 'Doctrine'));
    $category1->addQuiz($quiz2);


    // récupérer la question qui a pour title "Commande pour ajouter une entité ?"
    $question1 = $em->getRepository("CoopernetQuizBundle:Question")
      ->findOneBy(array('title' => 'Commande pour ajouter une entité ?'));
    //(cf https://docs.google.com/document/d/1-J4DPP_VPn_2_GeCOcQfnC_1YsKVJix6DMdg2F_47OM/edit#bookmark=id.oqnbzbmlkvxe)

    // récupérer la question qui a pour title "Création d'un entity manager ?"
    $question2 = $em->getRepository("CoopernetQuizBundle:Question")
      ->findOneBy(array('title' => "Création d'un entity manager ?"));

    // récupérer la question qui a pour title "Forcer la mise à jour du shéma de base de données ?"
    $question3 = $em->getRepository("CoopernetQuizBundle:Question")
      ->findOneBy(array('title' => "Forcer la mise à jour du shéma de base de données ?"));


    // récupérer la réponse qui a pour title "php bin/console doctrine:generate:entity"
    $answer1 = $em->getRepository("CoopernetQuizBundle:Answer")
      ->findOneBy(array('title' => 'php bin/console doctrine:generate:entity'));
    $answer2 = $em->getRepository("CoopernetQuizBundle:Answer")
      ->findOneBy(array('title' => 'thc bin/console doctrine:generate:entity'));

    // récupérer la réponse qui a pour title "$this->getDoctrine()->getManager();"
    $answer3 = $em->getRepository("CoopernetQuizBundle:Answer")
      ->findOneBy(array('title' => '$this->getDoctrine()->getManager();'));

    // récupérer la réponse qui a pour title "php bin/console doctrine:schema:update --force"
    $answer4 = $em->getRepository("CoopernetQuizBundle:Answer")
      ->findOneBy(array('title' => 'php bin/console doctrine:schema:update --force'));

    // ajout de la question à la réponse
    $question_answer1 = new QuestionAnswer();
    $question_answer1->setGoodAnswer(TRUE);
    $question1->addQuestion($question_answer1);
    $answer1->addAnswer($question_answer1);

    // ajout de la question à la réponse
    $question_answer2 = new QuestionAnswer();
    $question_answer2->setGoodAnswer(FALSE);
    $question1->addQuestion($question_answer2);
    $answer2->addAnswer($question_answer2);

    // ajout de la question à la réponse
    $question_answer3 = new QuestionAnswer();
    $question_answer3->setGoodAnswer(TRUE);
    $question2->addQuestion($question_answer3);
    $answer3->addAnswer($question_answer3);

    // ajout de la question à la réponse
    $question_answer4 = new QuestionAnswer();
    $question_answer4->setGoodAnswer(TRUE);
    $question3->addQuestion($question_answer4);
    $answer4->addAnswer($question_answer4);

    // Ajout des questions au quiz
    $quiz1->addQuestion($question1);
    $quiz2->addQuestion($question2);
    $quiz1->addQuestion($question3);

    $em->persist($question_answer1);
    $em->persist($question_answer2);
    $em->persist($question_answer3);
    $em->persist($question_answer4);

    // entrer en base de données
    $em->flush();

    $content = $this->get('templating')
      ->render('CoopernetQuizBundle:Quiz:createlinks.html.twig');
    return new Response($content);
  }

  public function viewAction(Request $request) {
    // On récupère notre paramètre tag
    $tag = $request->query->get('tag');
    /*return new Response(
      "Affichage de l'annonce d'id : ".$id.", avec le tag : ".$tag
    );*/

    $content = $this->get('templating')
      ->render('CoopernetQuizBundle:Home:view.html.twig', array(
        "nom" => "Douënel",
        "prenom" => "Yvan",
        "tag" => $tag
      ));
    return new Response($content);
  }
}