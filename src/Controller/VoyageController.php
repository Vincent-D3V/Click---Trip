<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Entity\Agency;
use App\Entity\History;
use App\Entity\StateHistory;
use Doctrine\ORM\EntityManager;
use App\Repository\StageRepository;
use App\Form\TravelerDetailFormType;
use App\Repository\AgencyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoyageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(StageRepository $stageRepo): Response
    {
        $inspirations = $stageRepo->findBy([], null, 6);
        return $this->render('homepage/index.html.twig', ['inspirations' => $inspirations]);
    }

    /**
     * @Route("/mon-voyage/planner", name="planner")
     */
    public function planner(): Response
    {
        return $this->render('planner/listing.html.twig');
    }

    /**
     * @Route("/mon-voyage/envoi-etapes", name="jsonsteps", options = {"expose" = true})
     */
    public function jsonsteps(Request $request, SessionInterface $session) : void
    {
        $json = json_decode($request->getContent());
        $session->set('planner', $json);
    }

    /**
     * @Route(
     *     "/mon-voyage/details",
     *     name="details",
     *     options = {
     *      "expose" = true
     *     }
     *     )
     */
    public function details(
        ObjectManager $manager,
        Request $request,
        SessionInterface $session,
        \Swift_Mailer $mailer
    ) : Response {

        $form = $this->createForm(TravelerDetailFormType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Un nouveau formulaire de contacte a été soumis.'))
                ->setFrom($_ENV['MAILER_CONTACT'])
                ->setTo($_ENV['MAILER_CONTACT'])
                ->setBody(
                    $this->renderView(
                        "planner/travelerDetailMail.html.twig",
                        [
                            "data" => $data,
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            if ($data['beginDate'] && $data['endDate']) {
                $dates=[$data['beginDate'], $data['endDate']];
            } else {
                $dates=[];
            };
            $session->set('dates', $dates);
            return $this->redirectToRoute("success");
        }
        return $this->render(
            'planner/travelerDetailForm.html.twig',
            [
                "form" => $form->createView()
            ]
        );
    }

    /**
     *
     * @Route(
     *     "/mon-voyage/envoi",
     *     name="success",
     *     options = {
     *      "expose" = true
     *     }
     *     )
     */
    public function addHistory(
        ObjectManager $manager,
        Request $request,
        SessionInterface $session,
        StageRepository $stageRepo
    ) {
        $data=$session->get('planner');
        $history = new History();
        $stage=new Stage();
        foreach ($data as $key => $value) {
            $stage=$stageRepo->findOneBy(['reference'=>$value->reference]);
            $history->addStage($stage);
        }
        $state=new StateHistory();
        $state->setState('Attente admin');
        $agency = $stage->getAgency();
        if (!empty($session->get('dates'))) {
            $history->setDateBegin($session->get('dates')[0])
            ->setDateEnd($session->get('dates')[1]);
        };
        $history->setState($state)
            ->setClient($this->getUser())
            ->setAgency($agency);
        $manager->persist($history);
        $manager->flush();

        return $this->render('planner/success.html.twig');
    }

    /**
     * @Route("/mon-voyage/{country}", name="destination")
     */
    public function destination($country, StageRepository $stageRepository)
    {
        $steps = $stageRepository->findBy(["destination" => $country]);
        return $this->render(
            "stage/destination.html.twig",
            [
                "steps" => $steps
            ]
        );
    }
}
