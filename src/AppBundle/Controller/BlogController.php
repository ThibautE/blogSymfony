<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Article;
use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends Controller{
    /**
     * @Route("/", name="accueil")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em ->createQuery(
            'SELECT article
            FROM AppBundle:Article article
            ORDER BY article.date'
        )->setMaxResults(10);
        $articles = $query->getResult();
        return $this->render('default/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/post/{url}", name="post")
     */
    public function postAction(Request $request, $url)
    {
        $em= $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneByUrl($url);
        return $this->render('default/post.html.twig',[
            "article"=>$article
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
        $em = $this->getDoctrine()->getManager();
        $query = $em ->createQuery(
            'SELECT articles
            FROM AppBundle:Article articles
            ORDER BY articles.date'
        );
        $articles = $query->getResult();
        return $this->render('default/allArticles.html.twig', [
            'articles' => $articles,
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
