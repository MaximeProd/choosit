<?php

namespace App\Controller;

use App\Form\ProduitType;
use App\Manager\ProduitsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class ProduitController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

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

        // Création du modèle du formulaire
        $model = $this->get('form.factory')->create(ProduitType::class, $produit);

        return $this->render('produit/fiche.html.twig', [
            'produit' => $produit,
            'form' => $model->createView()
        ]);
    }
}
