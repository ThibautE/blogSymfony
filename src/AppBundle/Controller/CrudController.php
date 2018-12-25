<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OC\PlatformBundle\Entity\Advert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;


class CrudController extends Controller{
    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $article = new Article();
        $article->setContenu("");
        $article->setTitre("");
        $article->setDate(new \DateTime());

        $form = $this->createFormBuilder($article)
            ->add('titre', TextType::class, array('label'=>'Titre de l\'article'))
            ->add('contenu', TextareaType::class, array('label'=>'Contenu de l\'article'))
            ->add('save', SubmitType::class, array('label' => 'Créer l\'article'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('default/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit/{idArticle}", name="edit")
     */
    public function editAction(Request $request, $idArticle)
    {
        $em= $this->getDoctrine()->getManager();
        $article = $em->find('AppBundle:Article',$idArticle);

        $form_article = new Article();
        $form_article->setTitre($article->getTitre());
        $form_article->setContenu($article->getContenu());

        $form = $this->createFormBuilder($form_article)
            ->add('titre', TextType::class)
            ->add('contenu', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Modifier l\'article'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setContenu($form['contenu']->getData());
            $article->setTitre($form['titre']->getData());
            dump($article);
            $em->flush();
            return $this->redirectToRoute('allArticles'); //retourner à la page des articles
        }

        return $this->render('default/edit.html.twig',[
            'form' => $form->createView(),
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
        return $this->redirectToRoute('accueil');
    }


}
