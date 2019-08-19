<?php

namespace App\Entity;

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

    public function __construct()
    {
        // Initialisation
        $this->dateCreation = new \DateTime('now');
    }
}
