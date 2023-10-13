<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/api/activity/{id}', name: 'api_detail_activity_get', methods: ['GET'])]
    public function getDetailActivity(
        Activity $activity,
        SerializerInterface $serializer
    ): JsonResponse {
        $jsonActivity = $serializer->serialize($activity, 'json', ['groups' => 'getActivities']);
        return new JsonResponse($jsonActivity, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/api/activity/{id}', name: 'api_activity_delete', methods: ['DELETE'])]
    public function deleteActivity(
        Activity $activity,
        EntityManagerInterface $em
    ): JsonResponse {
        $em->remove($activity);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
