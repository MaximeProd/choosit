<?php

namespace App\Controller;

use App\Form\FilmType;
use App\Manager\ProduitsManager;
use App\Manager\RoleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class ProduitController extends AbstractController
{

    private function getManager()
    {
        return new ProduitsManager($this->getDoctrine());
    }
    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {
        // Obtention du manager puis des films
        $produits = $this->getManager()->loadAllProduits();
        return $this->render('produit/index.html.twig', [
            'arrayProduits' => $produits,
        ]);
    }

    /**
     * @Route("/produit/fiche/{id}", name="produit_fiche")
     */

    public function edit(Request $request, $id): Response
    {
        // Obtention des manager
        $produitsManager = $this->getManager();
        // Recherche du produit
        if (!$produit = $produitsManager->loadProduit($id))
        {
            throw new NotFoundHttpException("Le produit n'existe pas");
        }

        return $this->render('produit/fiche.html.twig', [
            'produit' => $produit,
        ]);
    }
}
