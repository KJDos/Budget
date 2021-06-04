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
            return $this->redirectToRoute('income');
        }

        return $this->render('commons/render.html.twig', [
            'incomes' => $incomes,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/income/{id}/edit", name="edit_income")
     */
    public function edit($id, IncomeRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $income = $repo->find($id);
        $form = $this->createForm(IncomeType::class, $income);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($income);
            $manager->flush();

            $this->addFlash(
                'success',
                "Income <strong>{$income->getTitle()}</strong> has been modified."
            );

            return $this->redirectToRoute('income');
        }

        return $this->render('commons/edit.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/income/{id}/remove", name="remove_income")
     *
     * @return void
     */
    public function remove($id, IncomeRepository $repo, EntityManagerInterface $manager){

        $income = $repo->find($id);

        $manager->remove($income);
        $manager->flush();


        return $this->redirectToRoute('income');
    }

}
