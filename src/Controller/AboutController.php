<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Form\PartnerFormType;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/a-propos", name="about_")
 */
class AboutController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactForm(Request $request, Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Un nouveau formulaire de contacte a été soumis.'))
                ->setFrom($_ENV['MAILER_CONTACT'])
                ->setTo($_ENV['MAILER_CONTACT'])
                ->setBody(
                    $this->renderView(
                        "about/contactFormMail.html.twig",
                        [
                            "data" => $data,
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
        }
        return $this->render(
            'about/contactForm.html.twig',
            [
                "contactForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/inspiration", name="inspiration")
     */
    public function inspiration()
    {
        return $this->render('about/inspiration.html.twig');
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq()
    {
        return $this->render('about/faq.html.twig');
    }

    /**
     * @Route("/presse", name="presse")
     */
    public function presse()
    {
        return $this->render('about/presse.html.twig');
    }

    /**
     * @Route("/de-nous", name="qui_sommes_nous")
     */
    public function aboutUs()
    {
        return $this->render('about/aboutUs.html.twig');
    }

    /**
     * @Route("/mention-légale", name="mention_légale")
     */
    public function legalMention()
    {
        return $this->render('about/legalMention.html.twig');
    }
    
    /**
     * @Route("/services-associe", name="services-associe")
     */
    public function affiliateService()
    {
        return $this->render('about/affiliateService.html.twig');
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu()
    {
        return $this->render("about/cgu.html.twig");
    }

    /**
     * @Route("/nos-engagements", name="nos-engagements")
     */
    public function commitment()
    {
        return $this->render("about/commitment.html.twig");
    }

    /**
    * @Route("/devenir-partenaire", name="devenir-partenaire")
    */
    public function bePartner(Swift_Mailer $mailer, Request $request)
    {
        $form = $this->createForm(PartnerFormType::Class);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Une nouvelle demande de partenariat a été soumise.'))
                ->setFrom($_ENV['MAILER_FROM_ADDRESS'])
                ->setTo("vincent.mallard5@gmail.com")
                ->setBody(
                    $this->renderView(
                        "about/bePartnerMail.html.twig",
                        [
                            "data" => $data,
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
        }
        return $this->render(
            'about/bePartner.html.twig',
            [
                "form" => $form->createView()
            ]
        );
    }

    /**
     * @Route("politique-confidentialite", name="politique-confidentialite")
     */
    public function politiqueConfidentialite() :Response
    {
        return $this->render('about/politiqueDeConfidentialité.html.twig');
    }

    /**
     * @Route("/merci", name="merci")
     */
    public function thank() :Response
    {
        return $this->render('about/merci.html.twig');
    }
}
