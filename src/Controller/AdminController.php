<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Cycle;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @Route("/admin/users/formation/{id}", name="UserperFormations")
     */
    public function index(Cycle $formation = null, UserRepository $Repo)
    {
        $ok = true;
        if(!$formation)
            $users = $Repo->findAll();
        else
        {
            $users = $Repo->UsersPerFormation($formation->getId());
            $ok = false;
        }

        return $this->render('admin/admin.html.twig', [
            'users' => $users,
            'ok' => $ok
        ]);
    }

    /**
     * @Route("/admin/supprimerUser/{id}", name="suppUser")
     */
    public function deleteUser(User $user,ObjectManager $manager)
    {
        if($user->getRoles() == ["ROLE_ADMIN"])
            return $this->redirectToRoute("admin");
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute("admin");
    }
    /** 
     * @Route("/admin/AjouterUtilisateur", name="AjouterUtilisateur")
     * @Route("/admin/ModifierUtilisateur/{id}", name="ModifierUtilisateur")
     */
    public function GestionUtilisateur(User $user = null,ObjectManager $manager, Request $req, UserPasswordEncoderInterface $encoder)
    {
        if(!$user)
            $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('admin/utilisateur.html.twig', [
            'formUser' => $form->createView(),
            'ModeForm' => $user->getId()===null
        ]);
    }
}
