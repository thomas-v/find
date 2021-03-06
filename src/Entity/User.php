<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *      fields = {"email"},
 *      message = "L'email que vous souhaiter utiliser est deja enregistre"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre email doit être renseigné")
     * @Assert\Email(message="Votre email n'est pas au bon format")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Votre nom d'utilisateur doit être renseigné")
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre mot de passe doit être renseigné")
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire au minimum 8 caracteres")
     */
    private $password;
    
    /**
     * @Assert\NotBlank(message="La confirmation de votre mot de passe doit être renseignée")
     * @Assert\EqualTo(propertyPath="password", message="Le mot de passe confirme n'est pas identique")
     */
    private $confirm_password;

    /**
     
     * @ORM\OneToMany(targetEntity="App\Entity\Company", mappedBy="user", orphanRemoval=true)
     */
    private $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }
    
    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;
        
        return $this;
    }
    
    public function eraseCredentials(){
        
    }
    
    public function getSalt() {
        
    }
    
    public function getRoles(){
        return ['ROLE_USER'];
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setUser($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getUser() === $this) {
                $company->setUser(null);
            }
        }

        return $this;
    }
}
