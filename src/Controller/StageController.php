<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\StageType;
use Doctrine\ORM\EntityManager;
use App\Repository\StageRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Annotations\DocLexer;

/**
 * @Route("/etapes")
 */
class StageController extends AbstractController
{
    /**
     * @Route("/", name="stage_index", methods={"GET"})
     */
    public function index(StageRepository $stageRepository, Request $request): Response
    {
        $sortField=$request->query->get('sortField');
        if ($sortField!=null) {
            $orderBy=[$sortField => $request->query->get('sortDirection')];
        } else {
            $orderBy=[];
        }
        $stages=$stageRepository->findBy(['agency'=>$this->getUser()], $orderBy);
        return $this->render('stage/index.html.twig', [
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/ajouter", name="stage_new", methods={"GET","POST"})
     */
    public function new(Request $request, ObjectManager $manager): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stage->setAgency($this->getUser());
            $manager->persist($stage);
            $manager->flush();

            return $this->redirectToRoute('stage_index');
        }
        return $this->render('stage/new.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_show", methods={"GET"})
     */
    public function show(Stage $stage): Response
    {
        return $this->render('stage/show.html.twig', [
            'stage' => $stage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stage_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Stage $stage
    ): Response {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stage->setValidate(false)
                  ->setDeleted(false);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stage_index', [
                'id' => $stage->getId(),
            ]);
        }
        return $this->render('stage/edit.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_delete", methods={"DELETE"})
     */
    public function delete(EntityManager $entityManager, Request $request, Stage $stage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $stage->setDeleted(true);
            $entityManager->flush();
        }
        return $this->redirectToRoute('stage_index');
    }

    /**
     * @Route("/{destination}/{slug}", name="stage_detail")
     * @ParamConverter("stage", class="App\Entity\Stage", options={"mapping":{"slug":"slug"}} )
     */
    public function stageDetail(Stage $stage)
    {
        return $this->render('stage/details.html.twig', [
            'stage' => $stage,
        ]);
    }
}
