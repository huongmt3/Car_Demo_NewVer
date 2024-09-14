<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//add
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CarType;


class CarController extends AbstractController
{
    /**
     * @Route("/car", name="car_index")
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
   * @Route("/car/{id}", name="car_show", requirements={"id"="\d+"})
   */
  public function showAction(CarRepository $carRepository, int $id): Response
  {
      $car = $carRepository->find($id);

      if (!$car) {
          throw $this->createNotFoundException('The car does not exist');
      }

      return $this->render('car/show.html.twig', [
          'car' => $car,
      ]);
  }

    /**
     * @Route("/car/edit/{id}", name="car_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function editAction(int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository('App\Entity\Car')->find($id);

        if (!$car) {
            throw $this->createNotFoundException('Car not found');
        }

        $form = $this->createForm('App\Form\CarType', $car);

        if ($this->handleForm($form, $request, $car)) {
            $this->addFlash('notice', 'Car Edited');

            return $this->redirectToRoute('car_index');
        }

        return $this->render('car/edit.html.twig', [
            'form' => $form->createView(),
            'car' => $car,
        ]);
    }

    /**
     * @Route("/car/create", name="car_create", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function createAction(Request $request): Response
    {
        $car = new Car();
        $form = $this->createForm('App\Form\CarType', $car);

        if ($this->handleForm($form, $request, $car)) {
            $this->addFlash('notice', 'Car Added');

            return $this->redirectToRoute('car_index');
        }

        return $this->render('car/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function handleForm($form, Request $request, $car): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return true;
        }

        return false;
    }

/**
 * @Route("/car/delete/{id}", name="car_delete", methods={"POST"})
 */
public function deleteAction(int $id, Request $request): Response
{
    $em = $this->getDoctrine()->getManager();
    $car = $em->getRepository(Car::class)->find($id);

    if (!$car) {
        throw $this->createNotFoundException('Car not found');
    }

    if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
        $em->remove($car);
        $em->flush();

        $this->addFlash('notice', 'Car Deleted');
    }

    return $this->redirectToRoute('car_index');
}
}
