<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use App\Repository\FiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/filiere', name: 'filiere_')]
#[IsGranted('ROLE_ADMIN')]
class FiliereController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(FiliereRepository $filiereRepository): Response
    {
        return $this->render('filiere/index.html.twig', [
            'filieres' => $filiereRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'add')]
    public function add(Request $request, FiliereRepository $filiereRepository): Response
    {
        $filiere = new Filiere();
        $filiereForm = $this->createForm(FiliereType::class, $filiere);

        $filiereForm->handleRequest($request);

        if ($filiereForm->isSubmitted() && $filiereForm->isValid()) {
            $filiereRepository->save($filiere, true);

            $this->addFlash('success', 'La filière a bien été ajouté !');

            return $this->redirectToRoute('filiere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filiere/add.html.twig', [
            'filiere_form' => $filiereForm
        ]);
    }
}
