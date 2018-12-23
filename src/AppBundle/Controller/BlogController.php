<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends Controller{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/post/{id}", name="post")
     */
    public function postAction(Request $request, $id)
    {
        $date = new \DateTime();
        $article = new Post();
        $article->setTitre("Mon premier article");
        $article->setUrl("art".$date->getTimestamp());
        $article->setDate(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        // replace this example code with whatever you need
        return $this->render('default/post.html.twig', [
            'var' => $id,
        ]);
    }

}
