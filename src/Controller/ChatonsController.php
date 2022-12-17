<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Chaton;
use App\Form\CategorieSupprimerType;
use App\Form\CategorieType;
use App\Form\ChatonSupprimerType;
use App\Form\ChatonType;
use App\Form\ModifierchatonsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatonsController extends AbstractController
{
    /**
     * @Route("/chatons/{idCategorie}", name="chaton_voir")
     */
    public function index($idCategorie, ManagerRegistry $doctrine): Response
    {
        $categorie = $doctrine->getRepository(Categorie::class)->find($idCategorie);
        //si on n'a rien trouvé -> 404
        if (!$categorie) {
            throw $this->createNotFoundException("Aucune catégorie avec l'id $idCategorie");
        }

        return $this->render('chatons/index.html.twig', [
            'categorie' => $categorie,
            "chatons" => $categorie->getChatons()
        ]);
    }

    /**
     * @Route("/chaton/ajouter/", name="chaton_ajouter")
     */

    //    ---- AJOUTER CHATONS ---

    public function ajouterChaton(ManagerRegistry $doctrine, Request $request): Response
    {
        $chaton = new Chaton();

        $form = $this->createForm(ChatonType::class, $chaton);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($chaton);
            $em->flush();

            //retour à l'accueil
            return $this->redirectToRoute("chaton_voir", ["idCategorie" => $chaton->getCategorie()->getId()]);
        }

        return $this->render("chatons/ajouter.html.twig", [
            'formulaire' => $form->createView()
        ]);
    }

    //      --- SUPPRIMER CHATON ---

    /**
     * @Route("/chaton/supprimer/{id}", name="chaton_supprimer")
     */
    public function supprimerChaton($id, ManagerRegistry $doctrine, Request $request)
    {
        $chaton = $doctrine->getRepository(Chaton::class)->find($id);

        //si on n'a rien trouvé -> 404
        if (!$chaton) {
            throw $this->createNotFoundException("Aucun chaton avec l'id $id :(");
        }

        $form = $this->createForm(ChatonSupprimerType::class, $chaton);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->remove($chaton);

            $em->flush();

            return $this->redirectToRoute("chaton_voir", ["idCategorie" => $chaton->getCategorie()->getId()]);
        }

        return $this->render("chatons/supprimerchatons.html.twig", [
            'chaton' => $chaton,
            'formulaire' => $form->createView()
        ]);
    }

    //     --- MODFIIER CHATONS ---

    /**
     * @Route("/chatons/modifier/{id}", name="chatons_modifier")
     */
    public function chatonsModifier($id, ManagerRegistry $doctrine, Request $request){
        $chaton = $doctrine->getRepository(Chaton::class)->find($id);

        if(!$chaton){
            throw $this->createNotFoundException("Aucun chaton trouvé avec l'id $id");
        }

        $form=$this->createForm(ChatonType::class, $chaton);

        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()){

            $em=$doctrine->getManager();
            $em->persist($chaton);

            $em->flush();

            return $this->redirectToRoute("chaton_voir", ["idCategorie" => $chaton->getCategorie()->getId()]);
        }

        return $this->render("chatons/modifierchatons.html.twig",[
            'chaton'=>$chaton,
            'formulaire'=>$form->createView()
        ]);
    }

}
