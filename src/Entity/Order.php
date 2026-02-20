<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'integer')]
    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'], inversedBy: 'UserOrders')]
    private int $userId;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'integer')]
    #[ORM\ManyToOne(targetEntity: Service::class, cascade: ['persist'], inversedBy: 'ServiceOrders')]
    private int $serviceId;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'integer')]
    private int $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function setServiceId(int $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

}
