<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Manager\ProduitsManager;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class PanierController extends AbstractController
{
    private function getManager()
    {
        return new ProduitsManager($this->getDoctrine());
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session): Response
    {
        // Obtention le manager
        $produitsManager = $this->getManager();

        //Création du panier
        $panier = $session->get("panier", []);

        // Fabricataion des données
        $dataPanier = [];
        $total = 0;
        foreach ($panier as $id => $quantite){
            // Recherche du produit
            $produit = $produitsManager->loadProduit($id);
            $dataPanier[] = [
                "produit" => $produit,
                "quantite" => $quantite
            ];
            $total += $produit->getPrix() * $quantite;
        }

        return $this->render('panier/index.html.twig', [
            'dataPanier' => $dataPanier,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request, Produits $produit, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $produit->getId();
        $quantite = $request->get('quantite');

        dd($request);
        // Obtention des manager
        $produitsManager = $this->getManager();
        // Recherche du produit
        if (!$produit = $produitsManager->loadProduit($id))
        {
            throw new NotFoundHttpException("Le produit n'existe pas");
        }

        if(!empty($panier[$id])){
            $panier[$id] += $quantite;
        } else {
            $panier[$id] = $quantite;
        }
        //Sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("panier");
     }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function remove(Produits $produit, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $produit->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }

        }
        //Sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("panier");
    }

    /**
     * @Route("/panier/delete/{id}", name="panier_delete")
     */
    public function delete(Produits $produit, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $produit->getId();

        // Obtention des manager
        $produitsManager = $this->getManager();
        // Recherche du produit
        if (!$produit = $produitsManager->loadProduit($id))
        {
            throw new NotFoundHttpException("Le produit n'existe pas");
        }

        if(!empty($panier[$id])){
            unset($panier[$id]);


        }
        //Sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("panier");
    }

}
