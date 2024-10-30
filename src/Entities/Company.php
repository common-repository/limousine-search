<?php

namespace LimousineSearch\Entities;

class Company
{
    private string $id;
    private string $name;
    private string $slug;
    private ?string $mapsApiKey;
    private bool $isActivated;
    private string $timezone;

    private function __construct(
        string $id,
        string $name,
        string $slug,
        ?string $mapsApiKey,
        bool $isActivated,
        string $timezone
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->mapsApiKey = $mapsApiKey;
        $this->isActivated = $isActivated;
        $this->timezone = $timezone;
    }

    public static function fromApi(array $response): self
    {
        return new Company(
            $response['id'],
            $response['name'],
            $response['slug'],
            $response['maps_api_key'] ?? null,
            $response['is_activated'],
            $response['timezone'],
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function isActivated(): bool
    {
        return $this->isActivated;
    }

    public function getMapsApiKey(): ?string
    {
        return $this->mapsApiKey;
    }

    public function isMapsApiKeySet(): bool
    {
        return !empty($this->mapsApiKey);
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }
}
