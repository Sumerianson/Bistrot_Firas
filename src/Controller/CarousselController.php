<?php

namespace App\Controller;

use App\Entity\Caroussel;
use App\Entity\Formule;
use App\Form\CarousselType;
use App\Service\FileUploader;
use App\Repository\CarousselRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/caroussel')]
class CarousselController extends AbstractController
{
    #[Route('/', name: 'app_caroussel_index', methods: ['GET'])]
    public function index(CarousselRepository $carousselRepository): Response
    {
        return $this->render('caroussel/index.html.twig', [
            'caroussels' => $carousselRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_caroussel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Formule $formule, FileUploader $fileUploader, FormuleRepository $formuleRepository, CarousselRepository $carousselRepository): Response
    {
        $caroussel = new Caroussel();
        $formule = $this->createForm(CarousselType::class, $caroussel);
        $formule->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $caroussel->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $formule->setPhoto($fileName);
            }
            $carousselRepository->add($caroussel, true);

            return $this->redirectToRoute('app_caroussel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('caroussel/new.html.twig', [
            'caroussel' => $caroussel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_caroussel_show', methods: ['GET'])]
    public function show(Caroussel $caroussel): Response
    {
        return $this->render('caroussel/show.html.twig', [
            'caroussel' => $caroussel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_caroussel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FileUploader $fileUploader, Caroussel $caroussel, CarousselRepository $carousselRepository): Response
    {
        $form = $this->createForm(CarousselType::class, $caroussel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $caroussel->setPhoto($fileName);
            }
            $carousselRepository->add($caroussel, true);

            return $this->redirectToRoute('app_caroussel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('caroussel/edit.html.twig', [
            'caroussel' => $caroussel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_caroussel_delete', methods: ['POST'])]
    public function delete(Request $request, Caroussel $caroussel, CarousselRepository $carousselRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caroussel->getId(), $request->request->get('_token'))) {
            $carousselRepository->remove($caroussel, true);
        }

        return $this->redirectToRoute('app_caroussel_index', [], Response::HTTP_SEE_OTHER);
    }
}
