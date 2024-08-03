<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType; // Add this line to import the missing class
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/editor', name: 'app_admin_editor')]
class EditorController extends AbstractController
{
    #[Route('', name: 'app_admin_editor_index')]
    public function index(): Response
    {
        return $this->render('admin/editor/index.html.twig', [
            'controller_name' => 'EditorController',
        ]);
    }

    #[IsGranted('ROLE_AJOUT_DE_LIVRE')]
    #[Route('/new', name: 'app_admin_editor_new')]
    public function new(?Editor $editor, $request,EntityManagerInterface $manager): Response
    {
        if ($editor) {
            $this->denyAccessUnlessGranted('ROLE_EDITION_DE_LIVRE');
        }
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
           $manager->persist($editor);
           $manager->flush();

           return $this->redirectToRoute('app_admin_editor_new');
        }
        return $this->render('admin/editor/new.html.twig', [
            'form' => $form,
        ]);
    }
}
