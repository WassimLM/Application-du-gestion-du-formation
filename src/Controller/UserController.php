<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Cycle;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/inscription", name="Inscription")
     */
    public function inscription(ObjectManager $manager, Request $req, UserPasswordEncoderInterface $encoder, AuthorizationCheckerInterface $authChecker )
    {
        if($authChecker->isGranted('ROLE_ADMIN'))
            return $this->redirectToRoute('admin');
        else if ($authChecker->isGranted('ROLE_USER'))
            return $this->redirectToRoute('profil');
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

        return $this->render('user/inscription.html.twig', [
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="login")
     */
    public function login(ObjectManager $manager, AuthenticationUtils $authenticationUtils , UserPasswordEncoderInterface $encoder, AuthorizationCheckerInterface $authChecker )
    {  
        if($authChecker->isGranted('ROLE_ADMIN'))
            return $this->redirectToRoute('admin');
        else if ($authChecker->isGranted('ROLE_USER'))
            return $this->redirectToRoute('profil');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
