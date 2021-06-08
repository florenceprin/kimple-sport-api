<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Form\SportType;
use App\Repository\SportRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *
 */
class SportController extends AbstractController
{
    /**
     * @Route("/sports/{token}", name="sports_list", methods={"GET"})
     */
    public function list(SportRepository $sportRepository, SerializerInterface $serializer, string $token): Response
    {
        if ($token !== $this->getParameter('token')) {
            return new JsonResponse(['error' => 'true',
                'message' => 'Unauthorized'], '401');
        }


        try {

            $sports = $sportRepository->findAll();
            $sports = $serializer->normalize($sports, 'json');

            return new JsonResponse(['error' => false,
                'sports' => $sports]);
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()], 400);
        } catch (ExceptionInterface $e) {
        }
        return new JsonResponse(['error' => 'true',
            'message' => $e->getMessage()], 400);
    }

    /**
     * @Route("/sports/new/{token}", name="sport_new", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, string $token): Response
    {
        if ($token !== $this->getParameter('token')) {
            return new JsonResponse(['error' => 'true',
                'message' => 'Unauthorized'], 401);
        }


        try {

            $json = $request->getContent();
            $sport = $serializer->deserialize($json, Sport::class, 'json');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sport);
            $entityManager->flush();
            $sport = $serializer->normalize($sport, 'json');

            return new JsonResponse([
                'error' => false,
                'created' => $sport]);
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()], 400);
        } catch (ExceptionInterface $e) {
            return new JsonResponse(['error' => 'true',
                'message' => $e->getMessage()], 400);
        }
    }

    /**
     * @Route("/sports/{id}/{token}", name="sport_show", methods={"GET"})
     */
    public function show(Request $request, int $id, string $token): Response
    {

        if ($token !== $this->getParameter('token')) {
            return new JsonResponse(['error' => 'true',
                'message' => 'Unauthorized'], 401);
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $sport = $entityManager->getRepository(Sport::class)->find($id);
            return new JsonResponse([
                'error' => false,
                'sport' => $sport]);
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()], 400);
        }
    }

    /**
     * @Route("/sports/{id}/{token}", name="sport_edit", methods={"POST"})
     */
    public function edit(Request $request, int $id, SerializerInterface $serializer, string $token): Response
    {
        if ($token !== $this->getParameter('token')) {
            return new JsonResponse(['error' => 'true',
                'message' => 'Unauthorized'], 401);
        }


        try {
            $entityManager = $this->getDoctrine()->getManager();
            $sport = $entityManager->getRepository(Sport::class)->find($id);
            $json = $request->getContent();
            $serializer->deserialize($json, Sport::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $sport]);
            $entityManager->flush();
            $sport = $serializer->normalize($sport);

            return new JsonResponse(['error' => false,
                'sport' => $sport]);

        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()], 400);
        } catch (ExceptionInterface $e) {
            return new JsonResponse(['error' => 'true',
                'message' => $e->getMessage()], 400);
        }
    }

    /**
     * @Route("/sports/{id}/{token}", name="sport_delete", methods={"DELETE"})
     */
    public function delete(Request $request, int $id, string $token): Response
    {

        if ($token !== $this->getParameter('token')) {
            return new JsonResponse(['error' => 'true',
                'message' => 'Unauthorized'], 401);
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $sport = $entityManager->getRepository(Sport::class)->find($id);
            $entityManager->remove($sport);
            $entityManager->flush();

            return new JsonResponse(['error' => 'false',
                'deleted' => 'true']);
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()], 400);
        }
    }
}
