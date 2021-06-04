<?php

namespace App\Controller;

use App\Entity\Outcome;

use App\Form\OutcomeType;
use App\Repository\OutcomeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OutcomeController extends AbstractController
{
    /**
     * @Route("/outcome", name="outcome")
     */
    public function index(OutcomeRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $outcomes = $repo->findAll();

        $outcome = new Outcome();
        $form = $this->createForm(OutcomeType::class, $outcome);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($outcome);
            $manager->flush();

            $this->addFlash(
                'success',
                "outcome <strong>{$outcome->getTitle()}</strong> has been added."
            );
            return $this->redirectToRoute('outcome');
        }

        return $this->render('commons/render.html.twig', [
            'outcomes' => $outcomes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/outcome/{id}/edit", name="edit_outcome")
     */
    public function edit($id, OutcomeRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $outcome = $repo->find($id);
        $form = $this->createForm(outcomeType::class, $outcome);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($outcome);
            $manager->flush();

            $this->addFlash(
                'success',
                "Outcome <strong>{$outcome->getTitle()}</strong> has been modified."
            );

            return $this->redirectToRoute('outcome');
        }

        return $this->render('commons/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/outcome/{id}/remove", name="remove_outcome")
     *
     * @return void
     */
    public function remove($id, OutcomeRepository $repo, EntityManagerInterface $manager)
    {

        $outcome = $repo->find($id);

        $manager->remove($outcome);
        $manager->flush();


        return $this->redirectToRoute('outcome');
    }

}
