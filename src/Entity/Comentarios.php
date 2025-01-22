<?php

namespace App\Entity;

use App\Repository\ComentariosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentariosRepository::class)]
class Comentarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comentario = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comentarios')]
    private Category $user;

    #[ORM\ManyToOne(targetEntity: Posts::class, inversedBy: 'comentarios')]
    private $posts;

    #[ORM\Column(length: 255, nullable: true)]
    private ?datetime $fecha_publicacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getfecha_publicacion(): ?datetime
    {
        return $this->fecha_publicacion;
    }

    public function setfecha_publicacion(?datetime $fecha_publicacion): static
    {
        $this->fecha_publicacion = $fecha_publicacion;

        return $this;
    }
}
