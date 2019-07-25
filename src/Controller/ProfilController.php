<?php

namespace App\Controller;

use App\Entity\StateHistory;
use DateTime;
use App\Entity\Stage;
use App\Entity\Agency;
use App\Entity\History;
use App\Entity\Message;
use App\Service\SendToMailbox;
use App\Form\AccountAgencyType;
use App\Form\AccountClientType;
use App\Repository\PriceRepository;
use App\Repository\HistoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/profil", name="profil_",
 * options = {
 *      "expose" = true
 *     })
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
        ]);
    }

    /**
     * @Route("/historique", name="history", methods={"GET"})
     */
    public function adminHistoryView(
        HistoryRepository $historyRepository,
        PriceRepository $priceRepository
    ): Response {
        return $this->render('profil/history.html.twig', [
            'histories' => $historyRepository->findAllHistoryInfos($this->getUser()),
            'agencyBool' => $this->getUser() instanceof Agency,
        ]);
    }

    /**
     * @Route("/editer/client", name="edit_client")
     */
    public function editProfileClient(Request $request, ObjectManager $manager) :Response
    {
        $client = $this->getUser();
        
        $form = $this->createForm(AccountClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($client);
            $manager->flush();
            $this->redirectToRoute('homepage');
        }
            return $this->render('profil/editClient.html.twig', [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/editer/agence", name="edit_agency")
     */
    public function editProfileAgency(Request $request, ObjectManager $manager) :Response
    {
        $agency = $this->getUser();

        $form = $this->createForm(AccountAgencyType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($agency);
            $manager->flush();
            $this->redirectToRoute('homepage');
        }

        return $this->render('profil/editAgency.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/messagerie", name="mailbox")
     */
    public function listMessages(): Response
    {
        $user=$this->getUser();
        $id=$user instanceof User?0:$user->getId();
        $directories=explode("\\", get_class($user));
        return $this->render('mailbox/listmessages.html.twig', [
            'id' => $id,
            'type' => strtolower($directories[count($directories)-1])
        ]);
    }

    /**
     * @Route("/messagerie/nouveau", name="send_message", methods={"GET","POST"},
     * options = {
     *      "expose" = true
     *     })
     */
    public function newMessage(Request $request, SendToMailbox $sender) : Response
    {
        $json = json_decode($request->getContent(), true);
        $sender->sendMessage($json);

        return $this->json([], 200);
    }

    /**
     * @Route("/confirmationAgence/{id}", name="confirmationAgence")
     */
    public function confirmVoyageAgency(ObjectManager $manager, HistoryRepository $historyRepository, int $id)
    {
        $state = new StateHistory();
        $state->setState('Attente paiement');
        $history = $historyRepository->findOneBy(['id' => $id]);
        $history->setState($state);
        $manager->persist($history);
        $manager->flush();
        return $this->redirectToRoute("profil_history");
    }

    /**
     * @Route("/paiement/{id}", name="paiement")
     */
    public function paiement(HistoryRepository $historyRepository)
    {
        return $this->render('profil/paiement.html.twig', [
            'histories' => $historyRepository->findAllHistoryInfos($this->getUser()),
        ]);
    }

    /**
     * @Route("/paiementAccepter/{id}", name="paiementAccepter")
     */
    public function paiementAccepter(ObjectManager $manager, HistoryRepository $historyRepository, int $id)
    {
        $state = new StateHistory();
        $state->setState('Payé');
        $history = $historyRepository->findOneBy(['id' => $id]);
        $history->setState($state);
        $manager->persist($history);
        $manager->flush();
        return $this->redirectToRoute("profil_history");
    }
}
