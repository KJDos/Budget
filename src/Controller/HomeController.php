<?php

namespace App\Controller;

use App\Repository\IncomeRepository;
use App\Repository\OutcomeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $manager): Response
    {

        $incomes = $manager->createQuery('SELECT SUM(income.amount) FROM App\Entity\Income income')->getSingleScalarResult();
        $outcomes = $manager->createQuery('SELECT SUM(outcome.amount) FROM App\Entity\Outcome outcome')->getSingleScalarResult();
        $total = $incomes - $outcomes;


        return $this->render('home/home.html.twig',[
            'incomes' => $incomes,
            'outcomes' => $outcomes,
            'total' => $total,
        ]);
    }
}
