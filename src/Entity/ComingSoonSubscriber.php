<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ComingSoonSubscriberRepository;

/**
 * @ORM\Entity(repositoryClass=ComingSoonSubscriberRepository::class)
 * @UniqueEntity("email", message="Votre adresse mail est déjà enregistrée")
 */
class ComingSoonSubscriber
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "L'adresse {{ value }} n'est pas valide. Renseignes une adresse mail correcte pour être tenu informé."
     * )
     */
    private string $email;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private DateTime $subscribedAt;

    /**
     * ComingSoonSubscriber constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->subscribedAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getSubscribedAt(): DateTimeInterface
    {
        return $this->subscribedAt;
    }

    public function setSubscribedAt(DateTime $subscribedAt): self
    {
        $this->subscribedAt = $subscribedAt;

        return $this;
    }
}
