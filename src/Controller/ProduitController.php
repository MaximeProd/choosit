<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {
        $message = "Bonsoir";
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'message' => $message
        ]);
    }
}
