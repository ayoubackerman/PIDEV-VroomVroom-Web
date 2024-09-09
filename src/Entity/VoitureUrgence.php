<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VoitureUrgenceRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VoitureUrgence
 *
 * @ORM\Table(name="voiture_urgence")
 * @ORM\Entity(repositoryClass="App\Repository\VoitureUrgenceRepository")
 */
class VoitureUrgence
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_voiture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVoiture;

    /**
     * @var string
     *
     * @ORM\Column(name="modele", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le champ modèle ne peut pas être vide")
     * @Assert\Length(max=15, maxMessage="Le champ modèle ne peut pas dépasser {{ limit }} caractères")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]+$/",
     *     message="Le champ modèle ne doit contenir que des lettres alphabétiques"
     * )
     */
    private $modele;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le champ marque ne peut pas être vide")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9]+$/",
     *     message="Le champ marque ne doit contenir que des lettres alphabétiques et des chiffres"
     * )
     * @Assert\Length(
     *     max=15,
     *     maxMessage="Le champ marque ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le champ matricule ne peut pas être vide")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9]+$/",
     *     message="Le champ matricule ne doit contenir que des lettres alphabétiques et des chiffres"
     * )
     * @Assert\Length(
     *     max=15,
     *     maxMessage="Le champ matricule ne peut pas contenir plus de {{ limit }} caractères",
     *     min=6,
     *     minMessage="Le champ matricule doit etre supperiere ou égale a 6 caractére "
     * )
     */
    private $matricule;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_place", type="integer", nullable=false)
     * @Assert\NotBlank(message="le nombre de places est obligatoire")
     * @Assert\Range(min=1, max=4, notInRangeMessage="Le nombre de places doit être compris entre 1 et 4.")
     */
    private $nombrePlace;

    /**
     * @var int|null
     *
     * @ORM\Column(name="statuts", type="integer", nullable=true)
     * @Assert\NotBlank(message="le statut est obligatoire")
     * @Assert\Range(min=0, max=2, notInRangeMessage="Le statuts doit être compris entre 0 et 2.")
     */
    private $statuts;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     *
     */
    private $image;

    public function getIdVoiture(): ?int
    {
        return $this->idVoiture;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNombrePlace(): ?int
    {
        return $this->nombrePlace;
    }

    public function setNombrePlace(int $nombrePlace): self
    {
        $this->nombrePlace = $nombrePlace;

        return $this;
    }

    public function getStatuts(): ?int
    {
        return $this->statuts;
    }

    public function setStatuts(?int $statuts): self
    {
        $this->statuts = $statuts;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function __toString(): string
    {
        return $this->idVoiture;
    }


}
