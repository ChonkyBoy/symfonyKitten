<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Proprios;
use App\Entity\Chaton;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    public function _menu(ManagerRegistry $doctrine): Response
    {
        return $this->render('menu/_menu.html.twig', [
            'categories'=>$doctrine->getRepository(Categorie::class)->findAll()
        ]);
    }
}
