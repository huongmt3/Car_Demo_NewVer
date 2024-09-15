<?php

namespace App\Controller;

use App\Repository\SupplierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Supplier;
use App\Form\SupplierType;

class SupplierController  extends AbstractController
{
    /**
     * @Route("/suppliers/local", name="local_suppliers")
     */
    public function listLocalSuppliers(SupplierRepository $supplierRepository): Response
    {
        $suppliers = $supplierRepository->findLocalSuppliers();

        return $this->render('supplier/index.html.twig', [
            'suppliers' => $suppliers,
            'type' => 'Local',
        ]);
    }

    /**
     * @Route("/suppliers/importers", name="importer_suppliers")
     */
    public function listImporterSuppliers(SupplierRepository $supplierRepository): Response
    {
        $suppliers = $supplierRepository->findImporters();

        return $this->render('supplier/index.html.twig', [
            'suppliers' => $suppliers,
            'type' => 'Importers',
        ]);
    }
}
