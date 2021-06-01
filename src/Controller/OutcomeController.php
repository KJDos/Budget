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
                "Income <strong>{$outcome->getTitle()}</strong> has been added."
            );
            return $this->redirectToRoute('outcome');
        }

        return $this->render('outcome/outcome.html.twig', [
            'outcomes' => $outcomes,
            'form' => $form->createView()
        ]);
    }

}
