<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/profil/contact/add", name="Ajoutercontact")
     * @Route("/profil/contact/edit/{id}" , name="EditContact")
     */
    public function SendMessage(Contact $contact = null , Request $req, ObjectManager $manager)
    {
        if(!$contact)
            $contact = new Contact();
        else if($contact->getEtat() == 0 )
            return $this->redirectToRoute("listesMessage");
            
        $form = $this->createFormBuilder($contact)
                ->add("DemandeMessage")
                ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid() && $contact->getDemandeMessage()!=null)
        {
            $user = $manager->getRepository(User::class)->findOneBy(["id" => $this->get("security.token_storage")->getToken()->getUser()->getId()]);
           if($contact->getId() == null)
                $contact->setDateMessageDemande(new \DateTime());
            $contact->setEtat(1)
                    ->setUser($user);
            dump($contact);
            $manager->persist($contact);
            $manager->flush();
            return $this->redirectToRoute('listesMessage');
        }
        return $this->render('contact/Contact.html.twig', [  
            "formContact" => $form->createView(),
            "isEmty" => $contact->getDemandeMessage()!=null,
            "ModeForm" => $contact->getId() != null
        ]);
    }
    /**
     * @Route("/Messages/show", name="listesMessage")
     */
    public function Message(Request $req, ObjectManager $manager, UserInterface $user )
    {  
        return $this->render('contact/listesMessage.html.twig', [  
            "AllMessages" => $manager->getRepository(Contact::class)->findAll(),
            "UserMessages" => $manager->getRepository(Contact::class)->findBy(["user" => $user ])
        ]);
    }
    /**
     * @Route("/admin/Message/Delete/{id}", name="suppMessage")
     */
    public function suppMessage(Contact $contact = null, ObjectManager $manager)
    {   
        if(!$contact)
            return $this->redirectToRoute('listesMessage');
        $manager->remove($contact);
        $manager->flush();
        return $this->render('contact/listesMessage.html.twig', [  
            "Messages" => $manager->getRepository(Contact::class)->findAll()
        ]);
    }
    /**
     * @Route("/admin/Message/Edit/{id}", name="modifMessage")
     */
    public function ReponduMessage(Contact $contact=null, ObjectManager $manager, Request $req)
    {   
        if(!$contact)
            return $this->redirectToRoute('listesMessage');
        $form = $this->createFormBuilder($contact)
                     ->add("ReponceMessage")
                     ->getForm();
        $contact->setUser($manager->getRepository(User::class)->find($contact->getUser()->getId()));
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
           $contact->setEtat(0)
                   ->setDateReponceMessage(new \DateTime())
                   ->setIdAdmin($this->get("security.token_storage")->getToken()->getUser()->getId());
            $manager->persist($contact);
            $manager->flush();
            return $this->redirectToRoute("listesMessage");
        }
        return $this->render('contact/ReponceMessage.html.twig', [  
            "formReponceMessage" => $form->createView(),
            "Message" => $contact
        ]);
    }
}
