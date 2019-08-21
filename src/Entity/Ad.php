<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     *
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ titre ne peut pas être vide !")
     *
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank(message="Le champ description ne peut pas être vide !")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le champ ville ne peut pas être vide !")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\Regex("/[0-9]{5}/",message="Le champ code postal doit être au bon format !")
     * @Assert\NotBlank(message="Le champ code postal ne peut pas être vide !")
     */
    private $cp;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThan(0, message="Le prix doit être positif")
     * @Assert\NotBlank(message="Le champ prix ne peut pas être vide !")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */


    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie",inversedBy="ads")
     * @Assert\NotBlank(message="Le champ titre ne peut pas être vide !")
     *
     */
    private $categorie;

    /**
     * Plusieurs annonces peuvent avoir plusieurs users.
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="User", mappedBy="ads")
     */
    private $users;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="annonces")
     *@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie): void
    {
        $this->categorie = $categorie;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }


    public function addUser(User $user)
    {
        //$user->addUser($this); // synchronously updating inverse side
        $this->users[] = $user;
    }



    public function __construct()
    {
        // Initialisation
        $this->dateCreation = new \DateTime('now');
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }





}
