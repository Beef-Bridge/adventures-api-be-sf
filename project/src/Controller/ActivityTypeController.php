<?php

namespace App\Controller;

use App\Entity\ActivityType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ActivityTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/api/activity-type/{id}', name: 'api_activity_type_delete', methods: ['DELETE'])]
    public function deleteActivityType(
        ActivityType $activityType,
        EntityManagerInterface $em
    ): JsonResponse {
        $em->remove($activityType);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/activity-type', name: 'api_activity_type_post', methods: ['POST'])]
    public function createActivityType(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        UrlGeneratorInterface $urlGenerator
    ): JsonResponse {
        $activityType = $serializer->deserialize($request->getContent(), ActivityType::class, 'json');
        $em->persist($activityType);
        $em->flush();

        $jsonActivityType = $serializer->serialize($activityType, 'json', ['groups' => 'getActivityType']);

        $location = $urlGenerator->generate(
            'api_detail_activity_type_get',
            [
                'id' => $activityType->getId()
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse($jsonActivityType, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/activity-type/{id}', name: 'api_activity_type_put', methods: ['PUT'])]
    public function updateActivityType(
        Request $request,
        SerializerInterface $serializer,
        ActivityType $activityType,
        EntityManagerInterface $em
    ): JsonResponse {
        $updatedActivityType = $serializer->deserialize(
            $request->getContent(),
            ActivityType::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $activityType]
        );

        $em->persist($updatedActivityType);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
