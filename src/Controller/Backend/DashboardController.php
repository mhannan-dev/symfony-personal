<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[IsGranted(User::ROLE_ADMIN)]
final class DashboardController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/app-dashboard{_format}', name: 'app_dashboard', requirements: ['_format' => 'html|json'], defaults: ['_format' => 'html'], methods: ['GET'])]
    public function index(string $_format): Response
    {
       
        return $this->render('backend/dashboard.' . $_format . '.twig');
    }

    #[Route('/app-user-profile{_format}', name: 'app_user_profile', requirements: ['_format' => 'html|json'], defaults: ['_format' => 'html'], methods: ['GET'])]
    public function userProfile(string $_format): Response
    {

        return $this->render('backend/user/profile.' . $_format . '.twig');
    }
    
    
    #[Route('/dashboard-users{_format}', name: 'app_user_list', requirements: ['_format' => 'html|json'], defaults: ['_format' => 'html'], methods: ['GET'])]
    public function users(Request $request, string $_format): Response
    {
        $page = $request->query->getInt('page', 1);
        $paginator = $this->userRepository->findLatest($page);

        $data['users'] = $paginator;
        $data['page_title'] = "Users";
        $data['pagination'] = [
            'page' => $page,
            'pages_count' => ceil(count($paginator) / 5),
            'has_previous' => $page > 1,
            'has_next' => $page < ceil(count($paginator) / 5),
        ];
        return $this->render('backend/user/list.' . $_format . '.twig', $data);
    }
}
