<?php

namespace App\Controller;

use App\Repository\StageRepository;
use App\Repository\AgencyRepository;
use App\Repository\ClientRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route(
     *   "/api/stages",
     *   name="api_stages",
     *   options = {
     *     "expose" = true
     *   }
     * )
     */
    public function listStage(StageRepository $stageRepo)
    {
        $stages = $stageRepo->findAll();
        $stages=array_filter($stages, function ($v) {
            if (count($v->getAgency()->getStages())>2) {
                return $v;
            }
        });

        return $this->json($stages, 200, [], ['groups'=>'apiStage']);
    }

    /**
     * @Route(
     *   "/api/{user}/{id}",
     *   name="api_messages",
     *   options = {
     *     "expose" = true
     *   }
     * )
     */
    public function listMessage(
        string $user,
        int $id,
        ClientRepository $clientRepo,
        AgencyRepository $agencyRepo
    ) {
        switch ($user) {
            case 'client':
                $messages=$clientRepo->findBy(['id'=>$id])[0]->getMessages();
                break;
            case 'agence':
                $messages=$agencyRepo->findBy(['id'=>$id]);
                break;
            default:
                throw new HttpException(404, "Adresse introuvable...");
        }
        return $this->json($messages, 200, [], ['groups'=>'apiMessage']);
    }
}
