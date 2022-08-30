<?php

namespace App\Controller;

use App\Entity\Boissons;
use App\Form\BoissonsType;
use App\Service\FileUploader;
use App\Repository\BoissonsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/boissons')]
class BoissonsController extends AbstractController
{
    #[Route('/', name: 'app_boissons_index', methods: ['GET'])]
    public function index(BoissonsRepository $boissonsRepository): Response
    {
        return $this->render('boissons/index.html.twig', [
            'boissons' => $boissonsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_boissons_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileUploader $fileUploader, BoissonsRepository $boissonsRepository): Response
    {
        $boisson = new Boissons();
        $form = $this->createForm(BoissonsType::class, $boisson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $boisson->setPhoto($fileName);
            }
            $boissonsRepository->add($boisson, true);

            return $this->redirectToRoute('app_boissons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boissons/new.html.twig', [
            'boisson' => $boisson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boissons_show', methods: ['GET'])]
    public function show(Boissons $boisson): Response
    {
        return $this->render('boissons/show.html.twig', [
            'boisson' => $boisson,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_boissons_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FileUploader $fileUploader, Boissons $boisson, BoissonsRepository $boissonsRepository): Response
    {
        $form = $this->createForm(BoissonsType::class, $boisson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $boisson->setPhoto($fileName);
            }
            $boissonsRepository->add($boisson, true);

            return $this->redirectToRoute('app_boissons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boissons/edit.html.twig', [
            'boisson' => $boisson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boissons_delete', methods: ['POST'])]
    public function delete(Request $request, Boissons $boisson, BoissonsRepository $boissonsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boisson->getId(), $request->request->get('_token'))) {
            $boissonsRepository->remove($boisson, true);
        }

        return $this->redirectToRoute('app_boissons_index', [], Response::HTTP_SEE_OTHER);
    }
}
