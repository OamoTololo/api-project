<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/", name="vlog_list")
     */
    public function list()
    {
        return $this->json(self::POSTS);
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
}