<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AddressType;
use App\Entity\Address;

class AddressController extends AbstractController
{
    /**
     * @Route("/adresse/{id}/visualiser", name="address_show")
     */
    public function show(Address $address){
        
        $address = $this->getDoctrine()->getRepository(Address::class)->findOneBy(['id' => $address->getId()]);
        
        return $this->render('address/show.html.twig', [
            'address' => $address
        ]);
    }
    
    /**
     * @Route("/adresse/{id}/ajout", name="address_add")
     */
    public function add(Contact $contact, Request $request, ObjectManager $manager)
    {
        
        $address = new Address();
        
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $address->setContact($contact);
            $manager->persist($address);
            $manager->flush();
            
            return $this->redirectToRoute('address_show', ['id' => $address->getId()]);
        }
        
        return $this->render('address/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/adresse/{id}/modification", name="address_edit")
     */
    public function edit(Address $address, Request $request, ObjectManager $manager)
    {
        
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($address);
            $manager->flush();
            
            return $this->redirectToRoute('address_show', ['id' => $address->getId()]);
        }
        
        return $this->render('address/edit.html.twig', [
            'form' => $form->createView(),
            'address' => $address
        ]);
    }
    
    /**
     * @Route("/adresse/{id}/supprimer", name="address_remove")
     */
    public function remove(Address $address, ObjectManager $manager){
        
        $this->getDoctrine()
        ->getRepository(Address::class)
        ->deleteAddress($address->getContact()->getId());
        
        return $this->redirectToRoute('contact_list');
    }
}
