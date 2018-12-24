<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends Controller{
    /**
     * @Route("/", name="accueil")
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

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexionAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/connexion.html.twig', [

        ]);
    }

    /**
     * @Route("/allArticles", name="allArticles")
     */
    public function listArticlesAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/allArticles.html.twig', [

        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/contact.html.twig', [

        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/about.html.twig', [

        ]);
    }

}
