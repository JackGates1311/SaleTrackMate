<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GoodOrServiceController extends Controller
{
    private ?Company $selected_company;

    private UserService $userService;
    private CompanyService $companyService;

    public function __construct(UserService $userService, CompanyService $companyService)
    {
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->selected_company = null;
    }

    public function index(): Factory|View|Application
    {
        $this->selected_company = $this->companyService->findSelectedCompany(request()->query('company'));

        $user_companies = $this->userService->getUserCompanies();

        return view('goods_and_services', ['companies' => $user_companies,
            'selected_company' => $this->selected_company]);
    }

    public function createView(): Factory|View|Application
    {
        return view('create_edit_good_or_service');
    }

    public function create(Request $request)
    {
        //TODO implement logic for saving article there ... (and test it of course for side effects)

        dd($request->all());
    }
}
