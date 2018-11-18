<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/ajout", name="contact_add")
     * @Route("/contact/{id}/modification", name="contact_edit")
     */
    public function manage(Contact $contact = null, Request $request, ObjectManager $manager)
    {   
        if(!$contact){
            $contact = new Contact();
        }
        
        
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request); 
        
        
        if($form->isSubmitted() && $form->isValid()){
            
            if(empty($contact->getDate())){
                $contact->setDate(new \DateTime());
            }
            
            $manager->persist($contact);
            $manager->flush();
            
            return $this->redirectToRoute('contact_list');
        }
        
        return $this->render('contact/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $contact->getId() != null
        ]);
    }
    
    /**
     * @Route("/contact/liste", name="contact_list")
     */
    public function list(){
        
        $contacts = $this->getDoctrine()
        ->getRepository(Contact::class)
        ->getContactsByUser($this->getUser());
        
        return $this->render('contact/list.html.twig', [
            'contacts' => $contacts
        ]);
    }
    
    /**
     * @Route("/contact/{id}/supprimer", name="contact_remove")
     */
    public function remove(Contact $contact, ObjectManager $manager){
        
        $manager->remove($contact);
        $manager->flush();
        
        return $this->redirectToRoute('contact_list');
    }
    
}
