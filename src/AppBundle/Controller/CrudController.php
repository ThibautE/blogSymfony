<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OC\PlatformBundle\Entity\Advert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;


class CrudController extends Controller{
    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $date = new \DateTime();
        $article = new Post();
        $article->setContenu("");
        $article->setTitre("");
        $article->setUrl("art".$date->getTimestamp());
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
     * @Route("/update/{idArticle}", name="update")
     */
    public function updateAction(Request $request, $idArticle)
    {
        return $this->render('default/update.html.twig', [
            'var' => $idArticle,
        ]);
    }

    /**
     * @Route("/manage", name="manage")
     */
    public function manageAction(Request $request)
    {
        return $this->render('default/manage.html.twig', [

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
