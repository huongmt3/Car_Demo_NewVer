<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/car",name="car_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('App\Entity\Car')->findAll();

        return $this->render('car/index.html.twig', array(
            'cars' => $cars,
        ));
    }

  /**
   * Finds and displays a car entity.
   *
   * @Route("/car/{id}", name="car_show")
   */
  public function showAction(Car $car)
  {
    return $this->render('car/show.html.twig', array(
      'car' => $car,
    ));
  }
}
