<?php

namespace App\DataFixtures;

use App\Entity\VlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $vlogPost = new VlogPost();
        $vlogPost->setTitle('A fourth vlog post');
        $vlogPost->setPublished(new \DateTime('2025-03-20 13:51:00'));
        $vlogPost->setContent('Its the fourth vlog post but with data fixtures this time.');
        $vlogPost->setAuthor('Lentumetse Kutumela');
        $vlogPost->setSlug('a-fourth-vlog-post');

        $manager->persist($vlogPost);

        $vlogPost = new VlogPost();
        $vlogPost->setTitle('A fifth vlog post');
        $vlogPost->setPublished(new \DateTime('2025-03-20 13:51:00'));
        $vlogPost->setContent('Its the fifth vlog post but with data fixtures this time.');
        $vlogPost->setAuthor('Stompie Kutumela');
        $vlogPost->setSlug('a-fifth-vlog-post');

        $manager->persist($vlogPost);
        $manager->flush();


    }
}
