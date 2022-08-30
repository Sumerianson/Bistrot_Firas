<?php

namespace App\Controller;

use App\Entity\Formule;
use App\Entity\Caroussel;
use App\Service\FileUploader;
use App\Repository\FormuleRepository;
use App\Repository\CarousselRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FormuleRepository $formuleRepository): Response
    {
        $formules = $formuleRepository->findAll();
        return $this->render('home/index.html.twig', [
            'formules'=>$formules
        ]);
    }

    #[Route('/formule/{id}', name: 'app_formule', methods: ['GET'])]
    public function show_formule(Formule $formule): Response
    {
        return $this->render('home/formule.html.twig', [
            'formule'=>$formule
        ]);
    }

}
