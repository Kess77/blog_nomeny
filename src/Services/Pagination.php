<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class Pagination  {

    // Récuperer les entités dans laquelle on veut appeler
    private $entityClass;

    // la limite des nombres de pagination affiché 
    private $limit = 10;

    //la page ou je me trouve actuellement
    private $currentPage = 1;

    // manager
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function getPages(){
        //  Connaitre le total des enregistrements de la table
        $repo   = $this->manager->getRepository($this->entityClass);
        $total  = count($repo->findAll());

        $pages  = ceil($total/$this->limit);

        return $pages;


    }


    // la fonction va appeler les données 
    public function getData(){
        // - Calculer offset
         $offset  = $this->curentPage * $this->limit - $this->limit;

        // - Demander au repository de trouver les elements
        $repo  = $this->manager->getRepository($this->entityClass);
        $data  = $repo->findBy([],[], $this->limit, $offset);

        // - Renvoyer les elements 
        return $data;


    }

    





    public function setEntityClass ($entityClass){
        $this->entityClass = $entityClass;

        return $this;
    }
    public function getEntityClass (){
       return  $this->entityClass;
        
    }

    public function setLimit($limit){
        $this->limit = $limit;
        return $this;
    }
     public function getLimit (){
       return  $this->limit;
        
    }
    public function setPage ($page){
        $this->currentPage = $page;

        return $this;
    }
    public function getPage (){
       return  $this->currentPage;
        
    }


}