<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/service")
 */
class ServiceApiController extends AbstractController
{

    /**
     * @Route("/get_price_by_service", methods={"POST"})
     */
    public function getPriceByServiceApi(Request $request, ServiceRepository $serviceRepository): JsonResponse
    {
        if (!$request->request->has('service_id') || (int) $request->request->get('service_id') <= 0) {
            return new JsonResponse(['error' => 'service id not set'], Response::HTTP_BAD_REQUEST);
        }

        $service = $serviceRepository->findOneBy(['id' => (int) $request->request->get('service_id')]);

        if (!$service) {
            return new JsonResponse(['error' => 'service not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['price' => $service->getPrice()]);
    }
}
