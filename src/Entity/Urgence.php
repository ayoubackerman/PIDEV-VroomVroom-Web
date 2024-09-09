<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UrgenceRepository;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * Urgence
 *
 * @ORM\Table(name="urgence", indexes={@ORM\Index(name="fk_trajeturgence", columns={"id_trajet"}), @ORM\Index(name="fk_urgencevoiture", columns={"id_voiture"})})
 * @ORM\Entity(repositoryClass="App\Repository\UrgenceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Urgence
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_urgence", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUrgence;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_trajet", referencedColumnName="id_trajet")
     * })
     * @Assert\NotBlank(message="le trajet est obligatoire")
     */
    private $idTrajet;



    /**
     * @var VoitureUrgence
     *
     * @ORM\ManyToOne(targetEntity="VoitureUrgence")
     * @ORM\JoinColumn(name="id_voiture", referencedColumnName="id_voiture")
     */
    private $idVoiture;



    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le champ localisation ne peut pas être vide")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Le champ marque ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */

    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le champ description ne peut pas être vide")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Le champ description ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="statuts", type="string", length=255, nullable=false)
     * @Assert\Range(min=0, max=2, notInRangeMessage="Le statuts doit être compris entre 0 et 2.")
     */
    private $statuts ="0" ;

    /**
     * @var string
     *
     * @ORM\Column(name="temps", type="string", length=255, nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $temps = 'CURRENT_TIMESTAMP';

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->temps = (new \DateTime())->format('Y-m-d H:i:s');
    }

    public function getIdUrgence(): ?int
    {
        return $this->idUrgence;
    }

    public function getIdTrajet(): ?Trajet
    {
        return $this->idTrajet;
    }

    public function setIdTrajet(?Trajet $idTrajet): self
    {
        $this->idTrajet = $idTrajet;

        return $this;
    }

    public function getIdVoiture(): ?VoitureUrgence
    {
        return $this->idVoiture;
    }

    public function setIdVoiture(?VoitureUrgence $idVoiture): self
    {
        $this->idVoiture = $idVoiture;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

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

    public function getStatuts(): ?string
    {
        return $this->statuts;
    }

    public function setStatuts(string $statuts): self
    {
        $this->statuts = $statuts;

        return $this;
    }

    public function getTemps(): ?string
    {
        return $this->temps;
    }

    public function setTemps(string $temps): self
    {
        $this->temps = $temps;

        return $this;
    }


}
