<?php

namespace App\Controller;

use App\Entity\VlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/vlog")
 */
class VlogController extends AbstractController
{
    /**
     * @Route("/{page}", name="vlog_list", defaults={"page": 1}, requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $vlogRepository = $this->getDoctrine()->getRepository(VlogPost::class);
        $items = $vlogRepository->findAll();
        
        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function (VlogPost $item) {
                    return $this->generateUrl('vlog_by_slug', ['slug' => $item->getSlug()]);
                },
                $items)
            ]
        );
    }

    /**
     * @Route("/post/{id}", name="vlog_by_id", requirements={"id"="\d+"})
     */
    public function post(VlogPost $post): JsonResponse
    {
        return $this->json($post);
    }

    /**
     * @Route("/post/{slug}", name="vlog_by_slug")
     */
    public function postBySlug(VlogPost $post): JsonResponse
    {
        return $this->json($post);
    }

    /**
     * @Route("/add", name="add_vlog", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $vlogPost = $serializer->deserialize($request->getContent(), VlogPost::class, 'json');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vlogPost);
        $entityManager->flush();

        return $this->json($vlogPost);
    }
}