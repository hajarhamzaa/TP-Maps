<?php
declare(strict_types=1);

final class Position {
    private ?int $id;
    private float $latitude;
    private float $longitude;
    private DateTimeImmutable $date;
    private string $imei;

    public function __construct(
        ?int $id,
        float $latitude,
        float $longitude,
        DateTimeImmutable $date,
        string $imei
    ) {
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->date = $date;
        $this->imei = $imei;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getLatitude(): float {
        return $this->latitude;
    }

    public function getLongitude(): float {
        return $this->longitude;
    }

    public function getDate(): DateTimeImmutable {
        return $this->date;
    }

   public function getImei(): string {
    return $this->imei; 
}

    // Setters avec validation
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setLatitude(float $latitude): void {
        if ($latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException("Latitude invalide");
        }
        $this->latitude = $latitude;
    }

    public function setLongitude(float $longitude): void {
        if ($longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException("Longitude invalide");
        }
        $this->longitude = $longitude;
    }

    public function setDate(DateTimeImmutable $date): void {
        $this->date = $date;
    }

    public function setImei(string $imei): void {
        if (!preg_match('/^[0-9]{15}$/', $imei)) {
            throw new InvalidArgumentException("IMEI invalide");
        }
        $this->imei = $imei;
    }

    // Méthode pratique
    public function toArray(): array {
        return [
            'id' => $this->id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'imei' => $this->imei
        ];
    }
}