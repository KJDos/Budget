<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoanController extends AbstractController
{
    /**
     * @Route("/loan", name="loan")
     */
    public function index(): Response
    {
        $today = date("d-m-Y"); 
        dump($today);
        return $this->render('loan/loan.html.twig', [
            'controller_name' => 'LoanController',
        ]);
    }
}
