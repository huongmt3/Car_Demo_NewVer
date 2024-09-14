<?php
//DONE QUERY 1
namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Customer;
use App\Form\CustomerType;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customers", name="customer_index")
     */
    public function indexAction(): Response
    {
        return $this->redirectToRoute('customer_list_ascending');
    }

    /**
     * @Route("/customers/create", name="customer_create", methods={"GET", "POST"})
     */
    public function createAction(Request $request): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            $this->addFlash('notice', 'Customer Added');

            return $this->redirectToRoute('customer_list_ascending');
        }

        return $this->render('customer/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/customers/view/{id}", name="customer_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function viewAction(int $id, CustomerRepository $customerRepository): Response
    {
        $customer = $customerRepository->find($id);

        if (!$customer) {
            throw $this->createNotFoundException('The customer does not exist');
        }

        return $this->render('customer/view.html.twig', [
            'customer' => $customer,
        ]);
    }

    /**
     * @Route("/customers/edit/{id}", name="customer_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function editAction(int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('App\Entity\Customer')->find($id);

        if (!$customer) {
            throw $this->createNotFoundException('Customer not found');
        }

        $form = $this->createForm(CustomerType::class, $customer);

        if ($this->handleForm($form, $request, $customer)) {
            $this->addFlash('notice', 'Customer Edited');

            return $this->redirectToRoute('customer_list_ascending');
        }

        return $this->render('customer/edit.html.twig', [
            'form' => $form->createView(),
            'customer' => $customer,
        ]);
    }


    /**
     * @Route("/customers/delete/{id}", name="customer_delete", methods={"POST"})
     */
    public function deleteAction(int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository(Customer::class)->find($id);
    
        if (!$customer) {
            throw $this->createNotFoundException('Customer not found');
        }
    
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $em->remove($customer);
            $em->flush();
    
            $this->addFlash('notice', 'Customer Deleted');
        }
        return $this->redirectToRoute('customer_list_ascending');
    }

    //handleForm for saving data
    private function handleForm($form, Request $request, $customer): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return true;
        }

        return false;
    }

    /**
     * @Route("/customers/all/ascending", name="customer_list_ascending", methods={"GET"})
     */
    public function listAscendingAction(CustomerRepository $customerRepository): Response
    {
        $customers = $customerRepository->findAllOrderedByBirthdate('ASC');

        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
        ]);
    }

    /**
     * @Route("/customers/all/descending", name="customer_list_descending", methods={"GET"})
     */
    public function listDescendingAction(CustomerRepository $customerRepository): Response
    {
        $customers = $customerRepository->findAllOrderedByBirthdate('DESC');

        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
        ]);
    }
}
