<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
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
    private $label;

    /**
     * @ORM\Column(type="boolean",nullable="true")
     */
    private $team;

    /**
     * @ORM\Column(type="integer"),nullable="true",nullable="true")
     */
    private $members_number;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getTeam(): ?bool
    {
        return $this->team;
    }

    /**
     * @param boolean $team
     * @return Sport
     */
    public function setTeam(bool $team): Sport
    {
        $this->team = $team;
        return $this;
    }

    /**
     * @return integer
     */
    public function getMembersNumber(): ?int
    {
        return $this->members_number;
    }

    /**
     * @param int $members_number
     * @return Sport
     */
    public function setMembersNumber(int $members_number): Sport
    {
        $this->members_number = $members_number;

        return $this;
    }


}
