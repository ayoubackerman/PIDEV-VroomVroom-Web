<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="user_ibfk_1", columns={"id_user"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reclamation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @var string
     * @Assert\NotBlank(message=" reclamation cannot be empty ")
     *  @Assert\Length(
     *      min = 5,
     *      minMessage=" min length 5 caracteres "
     *     )
     * @ORM\Column(name="reclamation", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $reclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="resolution", type="string", length=255, nullable=false, options={"default"="Bien Envoyer"})
     * @Groups("post:read")
     */
    private $resolution = 'Bien Envoyer';

    /**
     * @var string
     *
     * @ORM\Column(name="type_reclamation", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $typeReclamation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="temps", type="datetime", nullable=true)
     * @Groups("post:read")
     */
    private $temps;

    public function getIdReclamation():  ? int
    {
        return $this->idReclamation;
    }

    public function getIdUser() :  ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser) : self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getReclamation():  ? string
    {
        return $this->reclamation;
    }

    public function setReclamation(string $reclamation) : self
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    public function getResolution():  ? string
    {
        return $this->resolution;
    }

    public function setResolution(string $resolution) : self
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getTypeReclamation():  ? string
    {
        return $this->typeReclamation;
    }

    public function setTypeReclamation(string $typeReclamation) : self
    {
        $this->typeReclamation = $typeReclamation;

        return $this;
    }

    public function getTemps():  ? \DateTimeInterface
    {
        return $this->temps;
    }

    public function setTemps( ? \DateTimeInterface $temps) : self
    {
        $this->temps = $temps;

        return $this;
    }
    public function __toString()
    {
        return $this->getReclamation();
    }
}
