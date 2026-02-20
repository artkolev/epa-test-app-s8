<?php

namespace App\DataFixtures;

use App\Entity\Service;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $manager->persist($user);

        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('qwe123');
        $user->setSalt('');

        $service = new Service();
        $manager->persist($service);
        $service->setTitle('Оценка стоимости автомобиля');
        $service->setPrice(500);
        $service->setActive(true);

        $manager->flush();
    }
}
