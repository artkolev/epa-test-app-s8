<?php

namespace App\Tests\Controller;

use App\Entity\Order;
use App\Entity\Service;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormControllerTest extends WebTestCase
{
    public function testUnloginForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/form');

        $this->assertResponseStatusCodeSame(401);
        $this->assertSelectorTextContains('#unlogin', 'Пожалуйста, авторизуйтесь');
    }

    public function testLoginForm(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@example.com');
        $client->loginUser($testUser);

        $client->request('GET', '/form');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name="order"]');

        $this->assertSelectorExists('select[name="order[service_id]"]');
        $this->assertSelectorExists('input[type="email"][name="order[email]"]');
        $this->assertSelectorExists('input[type="number"][name="order[price]"][disabled="disabled"]');
        $this->assertSelectorExists('button[type="submit"]');
    }

    public function testRequiredEmailForm(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@example.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/form');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name="order"]');

        $form = $crawler->selectButton('Подтвердить')->form();
        $form['order[email]'] = '';
        $client->submit($form);

        $this->assertSelectorTextContains('.invalid-feedback', 'Значение не должно быть пустым.');
    }

    public function testSendForm(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get('doctrine')->getManager();

        $userRepository = $entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@example.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/form');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name="order"]');

        $serviceRepository = $entityManager->getRepository(Service::class);
        $savedService = $serviceRepository->findOneBy([
            'active' => 'Оценка стоимости автомобиля'
        ]);
        $this->assertNotNull($savedService);

        $form = $crawler->selectButton('Подтвердить')->form();
        $form['order[service_id]']->select($savedService->getId());
        $form['order[email]'] = 'example@example.com';
        $client->submit($form);

        $orderRepository = $entityManager->getRepository(Order::class);
        $savedOrder = $orderRepository->findOneBy([
            'serviceId' => $savedService->getId(),
            'email' => 'example@example.com',
            'price' => $savedService->getPrice()
        ]);
        $this->assertNotNull($savedOrder);
    }
}
