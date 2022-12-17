<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Chaton;
use App\Entity\Proprios;
use App\Form\CategorieSupprimerType;
use App\Form\CategorieType;
use App\Form\ChatonSupprimerType;
use App\Form\ChatonType;
use App\Form\ModifierchatonsType;
use App\Form\ProprioType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class   PropriosController extends AbstractController
{
    /**
     * @Route("/proprios/{idProprio}", name="voir_proprios")
     */
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $proprio = new Proprios();

        $form=$this->createForm(ProprioType::class, $proprio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($proprio);
            $em->flush();

        }
        $repo=$doctrine->getRepository(Proprios::class);
        $proprio=$repo->findAll();

        return $this->render('proprios/index.html.twig', [
            'proprio'=>$proprio,
            'formulaire' => $form,
        ]);
    }

    /**
     * @Route("/proprios/ajouter/", name="ajouter_proprio")
     */
    public function ajouterProprios(ManagerRegistry $doctrine, Request $request)
    {
        $proprio = new Proprios();

        $form = $this->createForm(ProprioType::class, $proprio);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($proprio);
            $em->flush();

            return $this->redirectToRoute("voir_proprios", ["idProprios" => $proprio->getPrenom()->getId()]);
        }

        return $this->render("proprios/ajouter.html.twig",[
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/proprios/supprimer/{id}", name="supprimer_proprio")
     */
    public function supprimerProprio($id, ManagerRegistry $doctrine, Request $request)
    {
        $proprio = $doctrine->getRepository(Proprios::class)->find($id);

        //si on n'a rien trouvé -> 404
        if (!$proprio) {
            throw $this->createNotFoundException("Ton propriétaire avec l'id $id n'est pas de ce monde ! :(");
        }

        $form = $this->createForm(ProprioSupprimerType::class, $proprio);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->remove($proprio);

            $em->flush();

//            return $this->redirectToRoute("voir_proprio", ["idProprios" => $proprio->getCategorie()->getId()]);
        }

        return $this->render("proprios/supprimerproprio.html.twig", [
            'proprios' => $proprio,
            'formulaire' => $form->createView()
        ]);
    }


    /**
     * @Route ("/proprios/modifier/{id}", name="proprios_modifier")
     */

    public function propriosModifier($id, ManagerRegistry $doctrine, Request $request) {
        $proprio = $doctrine->getRepository(Proprios::class)->find($id);

        if (!$proprio) {
            throw $this->createNotFoundException("$id ne correspond à aucun proprios sowy");
        }
        $form=$this->createForm(PropriosType::class, $proprio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$doctrine->getManager();
            $em->persist($proprio);
            $em->flush();
//            return $this->redirectToRoute("voir_proprio", ["idProprios" => $proprio->getProprio()->getId()]);
        }
        return $this->render("proprios/modifierproprios.html.twig", [
            'proprios'=>$proprio,
            'formulaire'=>$form->createView()
        ]);
    }

}
