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
    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'hello-world',
            'title' => 'Hello World',
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'This is another post',
        ],
        [
            'id' => 3,
            'slug' => 'last-post',
            'title' => 'This is the last post',
        ],
        [
            'id' => 4,
            'slug' => 'first-post',
            'title' => 'This is the first post',
        ]
    ];

    /**
     * @Route("/{page}", name="vlog_list", defaults={"page": 1}, requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request)
    {
        $limit = $request->get('limit', 10);
        
        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function ($item) {
                    return $this->generateUrl('vlog_by_slug', ['slug' => $item['slug']]);
                },
                self::POSTS)
            ]
        );
    }

    /**
     * @Route("/{id}", name="vlog_by_id", requirements={"id"="\d+"})
     */
    public function post($id)
    {
        return $this->json(self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]);
    }

    /**
     * @Route("/{slug}", name="vlog_by_slug")
     */
    public function postBySlug($slug)
    {
        return $this->json(self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]);
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