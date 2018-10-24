<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Company;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CompanyType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class CompanyController extends AbstractController
{
    /**
     * @Route("/societe/ajout", name="company_add")
     * @Route("/societe/{id}/modification", name="company_edit")
     */
    public function manage(Company $company = null, Request $request, ObjectManager $manager, Security $security)
    {   
        if(!$company){
            $company = new Company();
        }
        
        
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request); 
        
        
        if($form->isSubmitted() && $form->isValid()){
            
            $user = $security->getUser();
            
            $company->setUser($user);
            
            $manager->persist($company);
            $manager->flush();
            
            return $this->redirectToRoute('company_list');
        }
        
        return $this->render('company/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $company->getId() != null
        ]);
    }
    
    /**
     * @Route("/societes/liste", name="company_list")
     */
    public function list(Security $security){
        
        $repository = $this->getDoctrine()->getRepository(Company::class);
        
        $companies = $repository->findBy(['user' => $security->getUser()], ['name' => 'ASC']);
        
        return $this->render('company/list.html.twig', [
            'companies' => $companies
        ]);
    }
    
    /**
     * @Route("/societe/{id}/supprimer", name="company_remove")
     */
    public function remove(Company $company, ObjectManager $manager){
        
        $manager->remove($company);
        $manager->flush();
        
        return $this->redirectToRoute('company_list');
    }
    
    
    
}
