<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Pdf;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\TextUI\XmlConfiguration\File;

class InheritanceEntitesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        for ($i = 0; $i < 2; $i++) {
            $author = new Author();
            $author->setName('John Doe-' . $i);

            $manager->persist($author);


            for ($j = 1; $j <= 2; $j++) {
                $pdf = new Pdf();
                $pdf->setFilename('pdf name of user ' . $i . ' - ' . $j);
                $pdf->setDescription('pdf description of user ' . $i . ' - ' . $j);
                $pdf->setSize(5454);
                $pdf->setOrientation('portrait');
                $pdf->setPagesNumber(123);
                $pdf->setAuthor($author);

                $manager->persist($pdf);
            }

            for ($k = 1; $k <= 2; $k++) {
                $video = new Video();
                $video->setFilename('video name of user ' . $i . ' - ' . $k);
                $video->setDescription('video description of user ' . $i . ' - ' . $k);
                $video->setSize(321);
                $video->setFormat('mpeg-2');
                $video->setDuration(123);
                $video->setTitle('video title of user ' . $i . ' - ' . $k);
                $video->setAuthor($author);

                $manager->persist($video);
            }
        }

        $manager->flush();
    }
}
