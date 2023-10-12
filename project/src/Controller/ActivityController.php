<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ActivityController extends AbstractController
{
    #[Route('/api/activity', name: 'api_activity_get', methods: ['GET'])]
    public function getActivityList(
        ActivityRepository $activityRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $activityList = $activityRepository->findAll();
        $jsonActivityList = $serializer->serialize($activityList, 'json', ['groups' => 'getActivities']);

        return new JsonResponse($jsonActivityList, Response::HTTP_OK, [], true);
    }
}
