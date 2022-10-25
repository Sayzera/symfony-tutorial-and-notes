<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Video;
use App\Entity\VideoX;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolimorfikContentController extends AbstractController
{
    #[Route('/polimorfik/content', name: 'app_polimorfik_content')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $comment = new Comment();
        $comment->setContent('Comment content');

        $post = new Post();
        $post->setContent('Post title');
        $post->setTitle('Post title');
        $post->addComment($comment);


        $videoComment = new Comment();
        $videoComment->setContent('Video comment content4');
        $video = new VideoX();
        $video->setTitle('Video title');
        $video->setVideoPath('Video path5');
        $video->addComment($videoComment);


        $doctrine->getManager()->persist($post);
        $doctrine->getManager()->persist($comment);
        $doctrine->getManager()->persist($video);
        $doctrine->getManager()->persist($videoComment);

        $doctrine->getManager()->flush();



        return $this->render('polimorfik_content/index.html.twig', [
            'controller_name' => 'PolimorfikContentController',
        ]);
    }

    #[Route('/polimorfik/content/show', name: 'app_polimorfik_content_show')]

    public function show(ManagerRegistry $doctrine): Response
    {
        $post = $doctrine->getRepository(Post::class)->find(1);
        $video = $doctrine->getRepository(VideoX::class)->find(5);

        foreach ($video->getComments() as $key => $value) {
            echo $value->getContent();
        }

        return new Response('Hello');
    }
}
