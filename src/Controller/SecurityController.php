<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationType;
use App\Entity\User;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, Security $security)
    {
        // on r�cup�re le user connect�
        $user = $security->getUser();
        
        //si il existe on bloque l'acc�s � cette route
        if($user != null){
            return $this->redirectToRoute('dashboard');
        }
        
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            
            $user->setPassword($hash);
            
            $manager->persist($user);
            $manager->flush();
            
            return $this->render('security/registration.html.twig', [
                'form' => $form->createView(),
                'title' => 'test',
                'success_registration' => true
            ]);
            
            //return $this->redirectToRoute('security_login', ['success_registration' => true]);
        }
        
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'title' => 'test',
            'success_registration' => true
        ]);
    }
    
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Security $security) {
        
        // on récupère le user connecté
        $user = $security->getUser();
        
        //si il existe on bloque l'accés à cette route
        if($user != null){
            return $this->redirectToRoute('dashboard');
        }
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig',[
            'email' => $lastUsername,
            'error' => $error
        ]);
        
    }
    
    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}
}
