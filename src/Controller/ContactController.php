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
            
            
            
            return $this->redirectToRoute('company_list');
        }
        
        return $this->render('contact/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $contact->getId() != null
        ]);
    }
}
