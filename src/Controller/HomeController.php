<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/{_format}', name: 'home', requirements: ['_format' => 'html|json'], defaults: ['_format' => 'html'])]
    public function index(Request $request, CategoryRepository $categoryRepository, string $_format): Response
    {
        $page = $request->query->getInt('page', 1);
        $items = $categoryRepository->findLatest($page);
        return $this->render('home/index.'.$_format.'.twig', [
            'paginator' => $items
        ]);
    }
}
