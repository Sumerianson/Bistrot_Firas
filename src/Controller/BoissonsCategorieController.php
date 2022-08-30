<?php

namespace App\Controller;

use App\Service\FileUploader;
use App\Entity\BoissonsCategorie;
use App\Form\BoissonsCategorieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\BoissonsCategorieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/boissons/categorie')]
class BoissonsCategorieController extends AbstractController
{
    #[Route('/', name: 'app_boissons_categorie_index', methods: ['GET'])]
    public function index(BoissonsCategorieRepository $boissonsCategorieRepository): Response
    {
        return $this->render('boissons_categorie/index.html.twig', [
            'boissons_categories' => $boissonsCategorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_boissons_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileUploader $fileUploader, BoissonsCategorieRepository $boissonsCategorieRepository): Response
    {
        $boissonsCategorie = new BoissonsCategorie();
        $form = $this->createForm(BoissonsCategorieType::class, $boissonsCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $boissonsCategorie->setPhoto($fileName);
            }
            $boissonsCategorieRepository->add($boissonsCategorie, true);

            return $this->redirectToRoute('app_boissons_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boissons_categorie/new.html.twig', [
            'boissons_categorie' => $boissonsCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boissons_categorie_show', methods: ['GET'])]
    public function show(BoissonsCategorie $boissonsCategorie): Response
    {
        return $this->render('boissons_categorie/show.html.twig', [
            'boissons_categorie' => $boissonsCategorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_boissons_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FileUploader $fileUploader, BoissonsCategorie $boissonsCategorie, BoissonsCategorieRepository $boissonsCategorieRepository): Response
    {
        $form = $this->createForm(BoissonsCategorieType::class, $boissonsCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le fichier présent dans le formulaire
            $picture = $form->get('photo')->getData();
            // si le champs picture est renseigné (si $picture existe)
            if($picture){
                // on récupère le nom du fichier téléversé en même temps qu'il est placé dans le dossier public/uploads/images/
                $fileName = $fileUploader->upload($picture);
                // on renseigne la propriété picture de l'article avec ce nom de fichier.
                $boissonsCategorie->setPhoto($fileName);
            }
            $boissonsCategorieRepository->add($boissonsCategorie, true);

            return $this->redirectToRoute('app_boissons_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boissons_categorie/edit.html.twig', [
            'boissons_categorie' => $boissonsCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boissons_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, BoissonsCategorie $boissonsCategorie, BoissonsCategorieRepository $boissonsCategorieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boissonsCategorie->getId(), $request->request->get('_token'))) {
            $boissonsCategorieRepository->remove($boissonsCategorie, true);
        }

        return $this->redirectToRoute('app_boissons_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
