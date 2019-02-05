<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecordRepository")
 */
class Record
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timein;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timeout;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimein(): ?\DateTimeInterface
    {
        return $this->timein;
    }

    public function setTimein(\DateTimeInterface $timein): self
    {
        $this->timein = $timein;

        return $this;
    }

    public function getTimeout(): ?\DateTimeInterface
    {
        return $this->timeout;
    }

    public function setTimeout(\DateTimeInterface $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function getSent(): ?bool
    {
        return $this->sent;
    }

    public function setSent(bool $sent): self
    {
        $this->sent = $sent;

        return $this;
    }
}
