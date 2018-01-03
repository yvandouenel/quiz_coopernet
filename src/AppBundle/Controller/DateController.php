<?php

namespace AppBundle\Controller;

// src/AppBundle/Controller/LuckyController.php

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DateController extends Controller {
  /**
   * @Route("/date")
   */
  public function dateAction() {
    $today = date('l jS \of F Y h:i:s A');

    return $this->render('date/date.html.twig', array(
      'date' => $today,
    ));

  }
}