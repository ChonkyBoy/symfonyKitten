<?php

namespace App\Entity;

use App\Repository\PropriosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropriosRepository::class)
 */
class Proprios
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Chaton::class, inversedBy="proprios")
     */
    private $possedance;

    public function __construct()
    {
        $this->possedance = new ArrayCollection();
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

    /**
     * @return Collection<int, Chaton>
     */
    public function getPossedance(): Collection
    {
        return $this->possedance;
    }

    public function addPossedance(Chaton $possedance): self
    {
        if (!$this->possedance->contains($possedance)) {
            $this->possedance[] = $possedance;
        }

        return $this;
    }

    public function removePossedance(Chaton $possedance): self
    {
        $this->possedance->removeElement($possedance);

        return $this;
    }
}
