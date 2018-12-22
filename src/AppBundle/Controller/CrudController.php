<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends Controller{
    /**
     * @Route("/create/{id}", name="create")
     */
    public function createAction(Request $request, $id)
    {
        $date = new \DateTime();
        $article = new Post();
        $article->setTitre("Mon premier article");
        $article->setContenu("Voici mon premier article");
        $article->setUrl("art".$date->getTimestamp());
        $article->getDate(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        // replace this example code with whatever you need
        return $this->render('default/post.html.twig', [
            'var' => $id,
        ]);
    }

    /**
     * @Route("/update/{idArticle}", name="update")
     */
    public function updateAction(Request $request, $idArticle)
    {
        return $this->render('default/update.html.twig', [
            'var' => $idArticle,
        ]);
    }

    /**
     * @Route("/delete/{idArticle}", name="delete")
     */
    public function deleteAction($idArticle)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->find("AppBundle:Article",$idArticle);
        if($article!=null){
            $em->remove($article);
            $em->flush();
        }else{
            throw $this->createNotFoundException('Pas d\'article avec cet id :', $idArticle);
        }
        return $this->redirectToRoute('homepage');
    }


}
