<?php

namespace App\Controller;

use App\Entity\History;
use App\Service\Invoice;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    /**
     * @Route("/facture/{id}", name="invoice")
     */
    public function showInvoice(History $history, Invoice $invoiceManager)
    {
        $invoice=$invoiceManager->createInvoice($history);

        return new RedirectResponse(
            $invoice->render(
                'facture-'.strval($history->getId())."-"
                .str_replace(':', '-', str_replace(' ', '-', strval(date("Y-m-d H:i:s")))).'.pdf',
                'I'
            )
        );
    }
}
