<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use App\Services\RecipientService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class RecipientController extends Controller
{
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

        $recipients = $this->recipientService->getByCompanyId(request()->query('company'));

        return view('recipients', ['companies' => $user_companies,
            'selected_company' => $this->selected_company, 'recipients' => $recipients]);
    }

    public function createView(): Factory|View|Application
    {
        return view('create_edit_recipient');
    }

    public function create(Request $request): RedirectResponse
    {
        $requestArray = $request->except('_token');

        $result = $this->recipientService->store($requestArray, $requestArray['company_id']);

        if ($result['success']) {
            return redirect()->route('recipients', ['company' => $result['recipient']['company_id']])
                ->with(['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput(request()->all());
        }

    }

    public function edit(): Factory|View|Application
    {
        $recipient = $this->recipientService->show(request()->query('recipient'))['recipient'];

        return view('create_edit_recipient', ['recipient' => $recipient]);
    }

    public function update(Request $request): RedirectResponse
    {
        $requestArray = $request->except('_token');
        $result = $this->recipientService->update($requestArray, $requestArray['recipient_id']);

        return $this->loadRecipientsPage($result);
    }

    public function delete(): RedirectResponse
    {
        $result = $this->recipientService->destroy(request()->query('recipient'));
        return $this->loadRecipientsPage($result);
    }

    /**
     * @param array $result
     * @return RedirectResponse
     */
    public function loadRecipientsPage(array $result): RedirectResponse
    {
        if ($result['success']) {
            return redirect()->route('recipients', ['company' => request()->query('company')])->
            with(['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput();
        }
    }
}
