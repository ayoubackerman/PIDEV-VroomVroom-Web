<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user")

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("user")

     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class)
     * @ORM\Column(type="json")
     * @Groups("user")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("user")

     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message=" last name cannot be empty ")
    * @Assert\Length(
    *      min = 2,
    *      minMessage=" min length 2 caracteres ")
    * @Assert\Regex(
    *    pattern ="/\d/",
    *   match=false,
    *  message="Your last name cannot contain a number",
    *     )
    * @Groups("user")

     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message=" name cannot be empty ")
    * @Assert\Length(
    *      min = 2,
    *      minMessage=" min length 2 caracteres ")
    * @Assert\Regex(
    *    pattern ="/\d/",
    *   match=false,
    *  message="Your name cannot contain a number",
    *     )
    * @Groups("user")

     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message=" username cannot be empty ")
     * @Groups("user")

     */
    private $Nomd;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user")

     */
    private $statuts;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     * @Assert\NotBlank(message="Vous devez insérer votre numéro de téléphone.")
     * @Assert\Regex(
     *     pattern="/^(9[0-9]|5[0-9]|2[0-9]|7[0-9])/i",
     *     match=true,
     *     message="le numero de telephone doit etre valide pour les operatueurs tunisiens "
     * )
     * @Assert\Length(
    *      min = 8,
    *      minMessage=" min length 8 caracteres " )
    * @Assert\Length(
    *      max = 8,
    *      maxMessage=" max length 8 caracteres "
    *
    *     )
    * @Groups("user")

     */
    private $num;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user")

     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("user")

     */
    private $activationToken;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user")

     */
    private $resetToken;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class)
     * @Groups("user")

     */
    private $id_role;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNomd(): ?string
    {
        return $this->Nomd;
    }

    public function setNomd(string $Nomd): self
    {
        $this->Nomd = $Nomd;

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

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

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

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function setActivationToken(?string $activationToken): self
    {
        $this->activationToken = $activationToken;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getIdRole(): ?Role
    {
        return $this->id_role;
    }

    public function setIdRole(?Role $id_role): self
    {
        $this->id_role = $id_role;

        return $this;
    }

    public function __toString()
    {
      
        return $this->id;
      
    }
    
}