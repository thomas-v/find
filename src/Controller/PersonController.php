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
     * @Route("/interlocuteur/{id}/visualiser", name="person_show")
     */
    public function show(Person $person){
        
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $person->getId()]);
        
        
        return $this->render('person/show.html.twig', [
            'person' => $person
        ]);
    }
    
    /**
     * @Route("/interlocuteur/{id}/ajout", name="person_add")
     */
    public function add(Contact $contact = null, Request $request, ObjectManager $manager)
    {
       
       $person = new Person();
        
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $contact->setPerson($person);
            $manager->persist($contact);
            $manager->persist($person);
            $manager->flush();
            
            return $this->redirectToRoute('person_show', ['id' => $person->getId()]);
        }
        
        return $this->render('person/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/interlocuteur/{id}/modification", name="person_edit")
     */
    public function edit(Person $person, Request $request, ObjectManager $manager)
    {
        
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($person);
            $manager->flush();
            
            return $this->redirectToRoute('person_show', ['id' => $person->getId()]);
        }
        
        return $this->render('person/edit.html.twig', [
            'form' => $form->createView(),
            'person' => $person
        ]);
    }
    
    /**
     * @Route("/interlocuteur/liste", name="person_list")
     */
    public function list(){
        
        $persons = $this->getDoctrine()
        ->getRepository(Person::class)
        ->getPersonsByUser($this->getUser()->getId());
        
        
        return $this->render('person/list.html.twig', [
            'persons' => $persons
        ]);
    }
    
    /**
     * @Route("/interlocuteur/{id}/supprimer", name="person_remove")
     */
    public function remove(Person $person, ObjectManager $manager){
        
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findOneBy(['person' => $person->getId()]);
        
        $person->removeContact($contact);
        $manager->remove($person);
        $manager->flush();
        
        return $this->redirectToRoute('contact_list');
    }
}
