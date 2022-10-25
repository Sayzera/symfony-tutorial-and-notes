<?php

namespace App\Entity;

use App\Repository\VideoXRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoXRepository::class)]
class VideoX extends Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $video_path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideoPath(): ?string
    {
        return $this->video_path;
    }

    public function setVideoPath(string $video_path): self
    {
        $this->video_path = $video_path;

        return $this;
    }
}
