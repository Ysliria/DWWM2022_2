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
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(FiliereRepository $filiereRepository): Response
    {
        return $this->render('filiere/index.html.twig', [
            'filieres' => $filiereRepository->findAll(),
        ]);
    }

    #[Route('/{filiere}/detail', name: 'show', methods: ['GET'])]
    public function detail(Filiere$filiere): Response
    {
        return $this->render('filiere/show.html.twig', [
            'filiere' => $filiere
        ]);
    }

    #[Route('/ajouter', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request, FiliereRepository $filiereRepository): Response
    {
        $filiere = new Filiere();
        $filiereForm = $this->createForm(FiliereType::class, $filiere);

        $filiereForm->handleRequest($request);

        if ($filiereForm->isSubmitted() && $filiereForm->isValid()) {
            $filiereRepository->save($filiere, true);

            $this->addFlash('success', 'La filière a bien été ajoutée !');

            return $this->redirectToRoute('filiere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filiere/add.html.twig', [
            'filiere_form' => $filiereForm
        ]);
    }

    #[Route('/{filiere}/modifier', name: 'update', methods: ['GET', 'POST'])]
    public function update(Filiere $filiere, FiliereRepository $filiereRepository, Request $request): Response
    {
        $filiereForm = $this->createForm(FiliereType::class, $filiere);

        $filiereForm->handleRequest($request);

        if ($filiereForm->isSubmitted() && $filiereForm->isValid()) {
            $filiereRepository->save($filiere, true);

            $this->addFlash('success', 'La filière ' . $filiere->getName() . ' a bien été modifiée !');

            return $this->redirectToRoute('filiere_show', ['filiere' => $filiere->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filiere/add.html.twig', [
            'filiere_form' => $filiereForm
        ]);
    }

    #[Route('/{filiere}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(Filiere $filiere, FiliereRepository $filiereRepository, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $filiere->getId(), $request->request->get('_token'))) {
            $filiereRepository->remove($filiere, true);

            $this->addFlash('success', 'La filière " ' . $filiere->getName() . ' " a bien été supprimée !');
        } else {
            $this->addFlash('warning', 'Une erreur est survenue !');
        }

        return $this->redirectToRoute('filiere_index');
    }
}
