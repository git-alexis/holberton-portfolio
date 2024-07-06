<?php

namespace App\Controller;

use App\Entity\SkillStrategy;
use App\Form\SkillStrategyType;
use App\Repository\SkillStrategyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/skill_strategy')]
class SkillStrategyController extends AbstractController
{
    #[Route('/', name: 'app_skill_strategy_index', methods: ['GET'])]
    public function index(SkillStrategyRepository $skillStrategyRepository): Response
    {
        return $this->render('skill_strategy/index.html.twig', [
            'skill_strategies' => $skillStrategyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_skill_strategy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skillStrategy = new SkillStrategy();
        $form = $this->createForm(SkillStrategyType::class, $skillStrategy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($skillStrategy);
            $entityManager->flush();

            return $this->redirectToRoute('app_skill_strategy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('skill_strategy/new.html.twig', [
            'skill_strategy' => $skillStrategy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_skill_strategy_show', methods: ['GET'])]
    public function show(SkillStrategy $skillStrategy): Response
    {
        return $this->render('skill_strategy/show.html.twig', [
            'skill_strategy' => $skillStrategy,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_skill_strategy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SkillStrategy $skillStrategy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SkillStrategyType::class, $skillStrategy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_skill_strategy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('skill_strategy/edit.html.twig', [
            'skill_strategy' => $skillStrategy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_skill_strategy_delete', methods: ['POST'])]
    public function delete(Request $request, SkillStrategy $skillStrategy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skillStrategy->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($skillStrategy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_skill_strategy_index', [], Response::HTTP_SEE_OTHER);
    }
}