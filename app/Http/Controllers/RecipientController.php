<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Recipient;
use App\Services\CompanyService;
use App\Services\RecipientService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    private ?Recipient $selected_recipient;

    private ?Company $selected_company;
    private RecipientService $recipientService;
    private UserService $userService;
    private CompanyService $companyService;

    public function __construct(RecipientService $recipientService, UserService $userService,
                                CompanyService   $companyService)
    {
        $this->recipientService = $recipientService;
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->selected_company = null;
    }

    public function index(): Factory|View|Application
    {
        $this->selected_company = $this->companyService->findSelectedCompany(request()->query('company'));

        $user_companies = $this->userService->getUserCompanies();

        return view('recipients', ['companies' => $user_companies, 'selected_company' => $this->selected_company]);
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
