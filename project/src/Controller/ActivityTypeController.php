<?php

namespace App\Controller;

use App\Entity\ActivityType;
use App\Repository\ActivityTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ActivityTypeController extends AbstractController
{
    #[Route('/api/activity-type', name: 'api_activity_type_get', methods: ['GET'])]
    public function getActivityTypeList(
        ActivityTypeRepository $activityTypeRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $activityTypeList = $activityTypeRepository->findAll();
        $jsonActivityTypeList = $serializer->serialize($activityTypeList, 'json', ['groups' => 'getActivityType']);
        return new JsonResponse($jsonActivityTypeList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/activity-type/{id}', name: 'api_detail_activity_type_get', methods: ['GET'])]
    public function getDetailActivityType(
        ActivityType $activityType,
        SerializerInterface $serializer
    ): JsonResponse {
        $jsonActivityType = $serializer->serialize($activityType, 'json', ['groups' => 'getActivityType']);
        return new JsonResponse($jsonActivityType, Response::HTTP_OK, ['accept' => 'json'], true);
    }
}
