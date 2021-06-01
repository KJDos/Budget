<?php

namespace App\Controller;

use App\Entity\Income;
use App\Form\IncomeType;
use App\Repository\IncomeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IncomeController extends AbstractController
{
    /**
     * @Route("/income", name="income")
     */
    public function index(IncomeRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {

        $incomes = $repo->findAll();

        $income = new Income();
        $form = $this->createForm(IncomeType::class, $income);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($income);
            $manager->flush();

            $this->addFlash(
                'success',
                "Income <strong>{$income->getTitle()}</strong> has been added."
            );
        }

        return $this->render('income/income.html.twig', [
            'incomes' => $incomes,
            'form' => $form->createView()
        ]);
    }

}