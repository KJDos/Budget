<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoanController extends AbstractController
{
    /**
     * @Route("/loan", name="loan")
     */
    public function index(LoanRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {

        $loans = $repo->findAll();

        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($loan);
            $manager->flush();

            $this->addFlash(
                'success',
                "Income <strong>{$loan->getTitle()}</strong> has been added."
            );
            return $this->redirectToRoute('income');
        }

        return $this->render('commons/render.html.twig', [
            'incomes' => $loans,
            'form' => $form->createView()
        ]);
    }
}
