<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OutcomeRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OutcomeRepository::class)
 * @UniqueEntity(fields={"title"}, message="This outcome already exist.")
 */
class Outcome
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=255, minMessage="Too short ! 3 letters min.", maxMessage="Too long ! 255 letters max.")
     * @Assert\Type("alpha", message="Must be a text.")
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float", message="Must be numbers.")
     * @Assert\NotEqualTo(value = 0, message="Can't be zero.")
     */
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
