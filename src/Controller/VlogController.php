<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/vlog")
 */
class VlogController extends AbstractController
{
    /**
     * @Route("/", name="vlog_list")
     */
    public function list()
    {

    }

    /**
     * @Route("/{id}", name="vlog_by_id")
     */
    public function post()
    {

    }

    /**
     * @Route("/{slug}", name="vlog_by_slug")
     */
    public function postBySlug()
    {

    }
}