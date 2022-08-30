<?php

namespace App\Controller;

use App\Entity\Formule;
use App\Repository\FormuleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarteController extends AbstractController
{
    #[Route('/panier', name: 'app_carte')]
    public function index(SessionInterface $session, FormuleRepository $formuleRepository): Response
    {
        $panier = $session->get('panier', []);
        
        $panierWithData = [];
        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'formule' => $formuleRepository->find($id),
                'quantity' => $quantity
            ];
        }
        $total = 0;
        foreach($panierWithData as $item){
            $totalItem = $item['formule']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }
        //dd($panierWithData);
        return $this->render('carte/index.html.twig', [
            'items' => $panierWithData,
            'total'=> $total
        ]);
    }

    #[Route('/panier/add/{id}', name: 'app_carte_add')]
    public function add($id, Formule $formule, SessionInterface $session)
    {
        $id = $formule->getId();
        //On récupère le panier
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
        $panier[$id] = 1;
        }
        //on sauvegarde dans la session
        $session->set('panier', $panier);

        //dd($session->get('panier'));
        return $this->redirectToRoute('app_carte');

    }

    #[Route('/panier/remove/{id}', name: 'app_carte_remove')]
    public function remove($id, Formule $formule, SessionInterface $session)
    {
        $id = $formule->getId();
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        } 
        $session->set('panier', $panier);
        //dd($session->get('panier'));
        return $this->redirectToRoute('app_carte');

    }

    #[Route('/panier/delete/{id}', name: 'app_carte_delete')]
    public function delete(Formule $formule, SessionInterface $session)
    {
        $id = $formule->getId();
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){

            unset($panier[$id]);
        } 
        $session->set('panier', $panier);
        //dd($session->get('panier'));
        return $this->redirectToRoute('app_carte');

    } 

    #[Route('/panier/delete', name: 'app_carte_delete_all')]
    public function deleteAll(SessionInterface $session)
    {
        $session->set('panier', []);

        return $this->redirectToRoute('app_carte');
    }
}
