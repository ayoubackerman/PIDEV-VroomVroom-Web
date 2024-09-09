<?php

namespace App\Entity;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\Collection;
use App\Validator\Constraints as CustomAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Trajet
 *
 * @ORM\Table(name="trajet", indexes={@ORM\Index(name="trajet_ibfk_1", columns={"id_user"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TrajetRepository")
 */
class Trajet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_trajet", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTrajet;

 /**
 * @var string
 *
 * @ORM\Column(name="ville_depart", type="string", length=255, nullable=false)
 * @Assert\NotBlank(message="La ville de départ doit être parmi les choix proposés")
 */
private $villeDepart;


/**
 * @var string
 *
 * @ORM\Column(name="ville_darrive", type="string", length=255 , nullable=false)
 * @Assert\NotBlank(message="Doit choisir une ville de darrive")
 */
private $villeDarrive;

/**
 * @var float|null
 *
 * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
 * @Assert\Type(type="float", message="Le prix doit être un nombre flottant.")
 * @Assert\NotBlank(message=" eeee nsitttt Le prix ")
 * @Assert\PositiveOrZero(message="Le prix doit être un nombre positif ou zéro.")
 */
private $prix;



    /**
     * @var int
     *
     * @ORM\Column(name="nbr_place", type="integer", nullable=false)
    * @Assert\NotBlank(message="Doit saisir le nombre de place ")
     */
    private $nbrPlace;

    /**
 * @var string
 *
 * @ORM\Column(name="date", type="string", length=255, nullable=false)
 *@Assert\NotBlank(message="La date doit être postérieure au 11 avrail 2023")
 * @Assert\Regex(
 *      pattern="/^\d{4}-\d{2}-\d{2}$/",
 *      message="Le format de date doit être AAAA-MM-JJ"
 * )
 * @Assert\GreaterThan( "2023-03-23", message="La date doit être postérieure au 23 mars 2023.")
 */
private $date;


    /**
 * @var string
 *
 * @ORM\Column(name="mode_paiement", type="string", length=255, nullable=false)
 * @Assert\NotBlank(message="Veuillez choisir un mode de paiement ")
 */
private $modePaiement;


   /**
 * @var \User
 *
 * @ORM\ManyToOne(targetEntity="User")
 * @ORM\JoinColumns({
 *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
 * })
 * @Assert\NotBlank(message=" eeee nsitttt Le prix ")
 */
private $idUser;


    public function getIdTrajet(): ?int
    {
        return $this->idTrajet;
    }

    public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(string $villeDepart): self
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getVilleDarrive(): ?string
    {
        return $this->villeDarrive;
    }

    public function setVilleDarrive(string $villeDarrive): self
    {
        $this->villeDarrive = $villeDarrive;

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

    public function getNbrPlace(): ?int
    {
        return $this->nbrPlace;
    }

    public function setNbrPlace(int $nbrPlace): self
    {
        $this->nbrPlace = $nbrPlace;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function __toString(): string
    {
        return $this->villeDepart;
    }
    public function __toString1(): string
    {
        return $this->idTrajet;
    }
}
