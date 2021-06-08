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
     * @Route("/sports", name="sport_index", methods={"GET"})
     */
    public function index(SportRepository $sportRepository, SerializerInterface $serializer): Response
    {
        try {

            $sports = $sportRepository->findAll();
            $sports = $serializer->normalize($sports, 'json');

            return new JsonResponse(['error' => false,
                'sports' => $sports]);
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()]);
        } catch (ExceptionInterface $e) {
        }  return new JsonResponse(['error' => 'true',
        'message' => $e->getMessage()]);
    }

    /**
     * @Route("/sports/new", name="sport_new", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer): Response
    {
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
                'message' => $ex->getMessage()]);
        } catch (ExceptionInterface $e) {
            return new JsonResponse(['error' => 'true',
            'message' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/sports/{id}", name="sport_show", methods={"GET"})
     */
    public function show(Request $request, Sport $sport): Response
    {
        try {
            return new JsonResponse([
                'error' => false,
                'sport' => $sport]);
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()]);
        }
    }

    /**
     * @Route("/sports/{id}", name="sport_edit", methods={"POST"})
     */
    public function edit(Request $request, Sport $sport, SerializerInterface $serializer): Response
    {
        try {

            $json = $request->getContent();
            $serializer->deserialize($json, Sport::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $sport]);
            $this->getDoctrine()->getManager()->flush();
            $sport=$serializer->normalize($sport);

            return new JsonResponse(['error' => false,
                'sport' => $sport]);

        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()]);
        } catch (ExceptionInterface $e) {
            return new JsonResponse(['error' => 'true',
                'message' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/sports/{id}", name="sport_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sport $sport): Response
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sport);
            $entityManager->flush();

            return new JsonResponse(['error' => 'false',
                'deleted' => 'true']);
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'true',
                'message' => $ex->getMessage()]);
        }
    }
}
