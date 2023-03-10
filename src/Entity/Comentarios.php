<?php

namespace App\Entity;

use App\Repository\ComentariosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentariosRepository::class)]
class Comentarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 90000)]
    private ?string $comentario = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comentarios')]
    private $user;

    #[ORM\ManyToOne(targetEntity: Posts::class, inversedBy: 'comentarios')]
    private $posts;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_posts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_posts;
    }

    public function setFechaPublicacion(\DateTimeInterface $fecha_posts): self
    {
        $this->fecha_posts = $fecha_posts;

        return $this;
    }
}
