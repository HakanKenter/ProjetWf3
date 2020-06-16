<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;



/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Cette Email est déjà utilisée !",
 * )
 * @UniqueEntity(
 *  fields={"pseudo"},
 *  message="Ce pseudo est déjà utilisée !",
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
     * @Assert\Length(min = 2, minMessage = "Veuillez saisir un prénom valide.")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2, minMessage = "Veuillez saisir un nom valide.")
     * 
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3, minMessage = "Votre pseudo doit contenir au minimum 3 caractères.")
     * 
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3, minMessage = "Veuillez saisir une ville.")
     */
    private $ville;

    /** 
     * @ORM\Column(type="string", length=255)
     */
    private $civilite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3, minMessage = "Veuillez saisir votre adresse.")
     * 
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 8, minMessage = "Votre mot de passe doit faire au minimum 8 caractères")
     * @Assert\EqualTo(propertyPath="confirm_password", message="Les mots de passes ne correspondent pas")
     */
    private $password;

    public $confirm_password;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual("-16 years", message="Vous devez avoir au moin 16 ans pour vous inscrire.")
     */
    private $birth;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email
     */
    private $email;

    public $cgv;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    private $Username;

    private $eraseCredentials;

    private $salt;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="user")
     */
    private $annonce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="produits_image", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="json")
     */
    private $Roles = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 10, max = 10, minMessage = "min_lenght", maxMessage = "max_lenght")
     * @Assert\Regex(pattern="/^[0-9]*$/", message="number_only") 
     */
    private $telephone;

 
    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $telephone;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(\DateTimeInterface $birth): self
    {
        $this->birth = $birth;

        return $this;
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

    public function getUsername()
    {
        
    }

    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getRoles()
    {
        return $this->Roles;
        // return ['ROLES_USER'];
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonce(): Collection
    {
        return $this->annonce;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonce->contains($annonce)) {
            $this->annonce[] = $annonce;
            $annonce->setUser($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonce->contains($annonce)) {
            $this->annonce->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getUser() === $this) {
                $annonce->setUser(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;
        
        if($this->imageFile instanceof UploadedFile){
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function __toString()
    {
        return $this->prenom;
    }

    public function setRoles($Roles)
    {
        // $Roles = ["ROLE_USER"];
        $this->Roles = $Roles;

        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

    }
    
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;


        return $this;
    }
}
