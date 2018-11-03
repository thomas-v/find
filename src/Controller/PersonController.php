<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Common\Persistence\ObjectManager;

class PersonController extends AbstractController
{
    /**
     * @Route("/interlocuteur/ajout/{contact_id}", name="person_add")
     */
    public function add($contact_id = null, Request $request, ObjectManager $manager)
    {
        if($contact_id != null){
            $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($contact_id);
        }
        
        $person = new Person();
        
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($person);
            
            if($contact){
                $contact->setPerson($person);
                $manager->persist($contact);
            }
            
            $manager->flush();
            
            return $this->redirectToRoute('contact_list');
        }
        
        return $this->render('person/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => null
        ]);
    }
}
