<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    /**
     * @Route("/admin/formateur/ajouter", name="Ajouter_formateur")
     * @Route("/admin/formateur/edit/{id}", name="editFormateur")
     */
    public function form(Formateur $formateur = null,  ObjectManager $manager, Request $req)
    {  
        if(!$formateur)
            $formateur = new Formateur();

        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($formateur);
            $manager->flush();
        }
        return $this->render('formateur/AjouterFormateur.html.twig', [
            'formFormateur' => $form->createView(),
            'EditMode' => $formateur->getId() !== null
        ]);
    }
    /**
     * @Route("/admin/formateur", name="Listes_Formateurs")
     */
    public function ListesFormateurs( ObjectManager $manager)
    {  
        return $this->render('formateur/Listes_Formateur.html.twig', [
            'Formateurs' => $manager->getRepository(Formateur::class)->findAll()
        ]);
    }
    /**
     * @Route("/admin/formateur/supprimer/{id}", name="Supprimer_Formateur")
     */
    public function SupprimerFormateur(Formateur $formateur = null,  ObjectManager $manager)
    {  
        if(!$formateur)
            return $this->redirectToRoute('Listes_Formateurs');
        $manager->remove($formateur);
        $manager->flush();
        return $this->redirectToRoute('Listes_Formateurs');
    }
}
