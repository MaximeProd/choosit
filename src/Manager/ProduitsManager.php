<?php


namespace App\Manager;
use App\Entity\Produits;
use Doctrine\Persistence\ManagerRegistry;
class ProduitsManager
{
    /* L'objet central de Doctrine : Manager Registry */
    protected $managerRegistry;
    /* Le référentiel lié à l'entité Produits */
    protected $repository;
    /**
     * ProduitsManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        /* Le contructeur nous permet de conserver le Manager Registry ... */
        $this->managerRegistry = $managerRegistry;
        /* ... et de créer le référentiel lié à l'entité Produits */
        $this->repository = $managerRegistry->getRepository(Produits::class);
    }
    /**
     * Load all Produit entity
     *
     * @return Produits[]
     */
    public function loadAllProduits()
    {
        return $this->repository->findAll();
    }
    /**
     * Load Produit entity
     *
     * @param Integer $produitId
     * @return object
     */
    public function loadProduit($produitId)
    {
        return $this->repository->find($produitId);
    }
}