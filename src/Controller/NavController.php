<?php

namespace App\Controller;

use mysql_xdevapi\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class NavController extends AbstractController
{
    /**
     * @Route("/nav", name="nav")
     */
    public function index(SessionInterface $session)
    {
        //Création du panier
        $panier = $session->get("panier", []);

        $total = 0;
        foreach ($panier as $id => $quantite){

            $total += $quantite;
        }
        return $this->render('nav/index.html.twig', [
            'totalPanier' => $total,
        ]);
    }
}
