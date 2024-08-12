<?php

namespace App\Controller\Backend;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard{_format}', name: 'app_dashboard', requirements: ['_format' => 'html|json'], defaults: ['_format' => 'html'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(string $_format): Response
    {
        return $this->render('backend/dashboard.'.$_format.'.twig');
    }
}
