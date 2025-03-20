<?php

namespace App\Controller;

use App\Entity\VlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function list($page = 1, Request $request)
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
    public function post($id)
    {
        return $this->json($this->getDoctrine()->getRepository(VlogPost::class)->find($id));
    }

    /**
     * @Route("/post/{slug}", name="vlog_by_slug")
     */
    public function postBySlug($slug)
    {
        return $this->json($this->getDoctrine()->getRepository(VlogPost::class)->findOneBy(['slug' => $slug]));
    }

    /**
     * @Route("/add", name="add_vlog", methods={"POST"})
     */
    public function add(Request $request)
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