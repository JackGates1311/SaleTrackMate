<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use App\Services\RecipientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    private ?Recipient $selected_recipient;
    private RecipientService $recipientService;

    public function __construct(RecipientService $recipientService)
    {
        $this->recipientService = $recipientService;
    }

    public function selectRecipient(Request $request): RedirectResponse
    {
        $selected_recipient_id = $request->input('recipient');

        $recipients = $this->recipientService->getByCompanyId($request->query('company'));

        foreach ($recipients as $recipient) {
            if ($recipient['id'] === $selected_recipient_id) {
                $this->selected_recipient = $recipient;
                break;
            }
        }

        return redirect()->route('create_invoice_view', ['recipient' => $selected_recipient_id])->
        with(['companies' => $recipients, 'selected_company' => $this->selected_recipient]);
    }
}
