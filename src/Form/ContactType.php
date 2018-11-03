<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\TypeContact;
use App\Entity\Company;
use App\Repository\CompanyRepository;

class ContactType extends AbstractType
{
    private $user;
    
    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('support', TextType::class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('comments')
            ->add('type', EntityType::class, array(
                'class' => TypeContact::class,
                'choice_label' => 'name',
            ))
            ->add('company', EntityType::class, array(
                'class' => Company::class,
                'choice_label' => 'name',
                'query_builder' => function (CompanyRepository $er) {
                    return $er->createQueryBuilder('c')
                                ->andWhere('c.user = :val')
                                ->setParameter('val', $this->user);
                },
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
