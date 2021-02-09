<?php

namespace App\Controller;

use App\Entity\Website;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $entityManager)
    {
        //return websites
        $websiteRepository = $entityManager->getRepository(Website::class);
        $websites = $websiteRepository->findAll();
        return $this->render('home/index.html.twig',compact('websites'));
    }
}
