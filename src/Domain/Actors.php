<?php

namespace App\Domain;

class Actors
{
    private bool $adult;
    private int $gender;
    private int $id;
    private string $name;
    private string $originalName;
    private float $popularity;
    private string $profilePath;

    public function __construct(
        bool $adult,
        int $gender,
        int $id,
        string $name,
        string $originalName,
        float $popularity,
        string $profilePath
    ) {
        $this->adult = $adult;
        $this->gender = $gender;
        $this->id = $id;
        $this->name = $name;
        $this->originalName = $originalName;
        $this->popularity = $popularity;
        $this->profilePath = $profilePath;
    }

    public function isAdult(): bool
    {
        return $this->adult;
    }

    public function getGender(): int
    {
        return $this->gender;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getPopularity(): float
    {
        return $this->popularity;
    }

    public function getProfilePath(): string
    {
        return $this->profilePath;
    }
}