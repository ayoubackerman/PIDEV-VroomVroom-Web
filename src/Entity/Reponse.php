<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="fk_reclamation", columns={"id_reclamation"}), @ORM\Index(name="fk_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Reponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idReponse;

    
    

    /**
     * @var int
     *
     * @ORM\Column(name="id_reclamation", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $idReclamation;
/**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     * @Groups("post:read")
     */
    private $idUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reponse", type="string", length=255, nullable=true, options={"default"="En cours de traitement......"})
     * @Groups("post:read")
     */
    private $reponse = 'En cours de traitement......';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="temps", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     * @Groups("post:read")
     */
    private $temps;

    public function getIdReponse(): ?int
    {
        return $this->idReponse;
    }

    public function getIdReclamation(): ?int
    {
        return $this->idReclamation;
    }

    public function setIdReclamation(int $idReclamation): self
    {
        $this->idReclamation = $idReclamation;

        return $this;
    }

    public function getIdUser() :  ? User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser) : self
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getTemps(): ?\DateTimeInterface
    {
        return $this->temps;
    }

    public function setTemps(?\DateTimeInterface $temps): self
    {
        $this->temps = $temps;

        return $this;
    }
}
