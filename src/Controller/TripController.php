<?php


namespace App\Controller;


use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
    /**
     * @Route("/api/trips/cities", name="get_citites")
     */
    public function getCities(StageRepository $stageRepository) {
        $cities = $stageRepository->getCities();
        return $this->json($cities);
    }
}