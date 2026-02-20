<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Form\Type\OrderType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="app_form")
     */
    public function index(Request $request, EntityManagerInterface $em, ServiceRepository $serviceRepository): Response
    {
        if (!$this->getUser()) {
            return $this->render(
                'error/401_unauthorized.html.twig',
                [],
                new Response(null, Response::HTTP_UNAUTHORIZED)
            );
        }

        $order = new Order();
        $order->setUserId($this->getUser()->getId());
        $order->setEmail($this->getUser()->getEmail());
        $order->setPrice(0);

        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Order $order */
            $order = $form->getData();
            $order->setPrice((int) $serviceRepository->find($order->getServiceId())->getPrice());

            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('app_order', ['send_succes' => 1]);
        }

        return $this->renderForm('form/index.html.twig', ['form' => $form]);
    }
}