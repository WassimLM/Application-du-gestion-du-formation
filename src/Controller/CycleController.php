<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Cycle;
use App\Form\CycleType;
use App\Entity\Formateur;
use App\Entity\Participation;
use App\Repository\UserRepository;
use App\Repository\CycleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CycleController extends AbstractController
{
    /**
     * @Route("/admin/cycle/ajouter", name="Ajout_cycle")
     * @Route("/admin/cycle/edit/{id}", name="edit_cycle")
     */
    public function form(Cycle $cycle = null,Request $req, ObjectManager $manager)
    {
        if(!$cycle)
            $cycle = new Cycle();

        $form = $this->createForm(CycleType::class, $cycle);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!$cycle->getId())
                $cycle->setDateCreation(new \DateTime()); 
            $manager->persist($cycle);
            $manager->flush();
            return $this->redirectToRoute("Lister_cycle");
        }

        return $this->render('cycle/index.html.twig', [
            'formCycle' => $form->createView(),
            'editMode'  => $cycle->getId() !== null
        ]);
    }
    /**
     * @Route("/admin/cycles", name="Lister_cycle")
     * @Route("/admin/cycles/user/{id}", name="cyclesPerUser")
     */
    public function liste(CycleRepository $Repo, User $user = null)
    {
        $ok = true;
        if(!$user)
            $cycles= $Repo->findAll();
        else
        {
            $ok = false;
            $cycles = $Repo->FormationsPerUser($user->getId());
        }

        return $this->render('cycle/liste_cycle_formation.html.twig', [
            'Cycles' => $cycles,
            'ok' => $ok
        ]);
    }
    /**
     * @Route("/admin/cycle/supprimer/{id}", name="Supprimer_cycle")
     */
    public function SupprimerCycle(Cycle $cycle,ObjectManager $manager)
    {
        $manager->remove($cycle);
        $manager->flush();
        
        return $this->redirectToRoute("Lister_cycle");
    }
    /**
     * @Route("/test", name="test")
     */
    public function test(CycleRepository $Repository, ObjectManager $manager)
    {
        /*$user = $manager->getRepository(User::class)->find(8);
        $cycle = $manager->getRepository(Cycle::class)->find(7);
        $Participation = new Participation();
        $Participation->setIdUser($user)
                      ->setIdCycle($cycle)
                      ->setDateParticipation(new \DateTime());
        $manager->persist($Participation);
        $manager->flush();*/
        
        dump($Repository->FormationsNoParticipe(10,$manager));
        return $this->render('cycle/test.html.twig');
    }
}
