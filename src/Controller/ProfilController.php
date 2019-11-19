<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Entity\Participation;
use App\Repository\CycleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(CycleRepository $Repo, UserInterface $user, ObjectManager $obj)
    {
        return $this->render('profil/profil.html.twig', [
            'Cycles' => $Repo->FormationsNoParticipe($user->getId(), $obj),
        ]);
    }
    /**
     * @Route("/profil/participer/{id}", name="participer")
    */
    public function Participer(Cycle $cyle,UserInterface $user, ObjectManager $manager)
    {
        $participation = new Participation();
        $participation  ->setIdUser($user)
                        ->SetIdCycle($cyle);
        $manager->persist($participation);
        $manager->flush();

        return $this->redirectToRoute('profil');
    }
    /**
     * @Route("/profil/MesFormations", name="MesFormations")
     */
    public function MesFormation(CycleRepository $Repo, UserInterface $user)
    {
        return $this->render('profil/MesFormations.html.twig', [
            'Cycles' => $Repo->FormationsParticipe($user->getId()),
        ]);
    }
    /**
     * @Route("/profil/MesFormations/ignore/{id}", name="IgnorerFormation")
     */
    public function Ignore(Cycle $cycle, UserInterface $user, ObjectManager $manager)
    {
        $manager->remove($manager->getRepository(Participation::class)->findOneBy(['id_user' => $user, 'id_Cycle' => $cycle]));
        $manager->flush();

        return $this->redirectToRoute('profil');
    }
}
