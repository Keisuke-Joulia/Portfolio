<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Project;
use App\Form\ContactType;
use App\Repository\AboutRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    private $aboutRepository;
    private $projectRepository;

    public function __construct(
        AboutRepository $aboutRepository,
        ProjectRepository $projectRepository
    ) {
        $this->aboutRepository = $aboutRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('front/index.html.twig', [
            'about' => $this->aboutRepository->findAll()[0],
        ]);
    }

    /**
     * @Route("/projets", name="all_projects")
     */
    public function AllProjects(): Response
    {
        return $this->render('front/all_projects.html.twig', [
            'projects' => $this->projectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/projet/{slug}", name="show_projects")
     */
    public function showProject(Project $project): Response
    {
        return $this->render('front/show_project.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/a-propos", name="about")
     */
    public function About(): Response
    {
        return $this->render('front/about.html.twig', [
            'about' => $this->aboutRepository->findAll()[0],
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success', 'Votre message à bien été envoyé, je vous réponds au plus vite !');

            return $this->redirectToRoute('contact');
        }

        return $this->render('front/contact.html.twig', [
            'contact' => $contact,
            'form' => $form->createView()
        ]);
    }
}
