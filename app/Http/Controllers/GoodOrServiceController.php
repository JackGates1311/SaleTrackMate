<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use App\Services\GoodOrServiceService;
use App\Services\TaxCategoryService;
use App\Services\UnitOfMeasureService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GoodOrServiceController extends Controller
{
    private ?Company $selected_company;
    private UserService $userService;
    private CompanyService $companyService;
    private UnitOfMeasureService $unitOfMeasureService;
    private TaxCategoryService $taxCategoryService;
    private GoodOrServiceService $goodOrServiceService;

    public function __construct(UserService          $userService, CompanyService $companyService,
                                TaxCategoryService   $taxCategoryService, UnitOfMeasureService $unitOfMeasureService,
                                GoodOrServiceService $goodOrServiceService)
    {
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->selected_company = null;
        $this->taxCategoryService = $taxCategoryService;
        $this->unitOfMeasureService = $unitOfMeasureService;
        $this->goodOrServiceService = $goodOrServiceService;
    }

    public function index(): Factory|View|Application
    {
        $this->selected_company = $this->companyService->findSelectedCompany(request()->query('company'));

        $user_companies = $this->userService->getUserCompanies();

        $goods_or_services = $this->goodOrServiceService->findByCompanyId(request()->query('company'))
        ['goods_or_services'];

        return view('goods_and_services', ['companies' => $user_companies,
            'selected_company' => $this->selected_company, 'goods_or_services' => $goods_or_services]);
    }

    public function createView(): Factory|View|Application
    {
        $tax_categories = $this->taxCategoryService->index()['tax_categories'];

        $unit_of_measures = $this->unitOfMeasureService->index()['unit_of_measures'];

        return view('create_edit_good_or_service', ['tax_categories' => $tax_categories,
            'unit_of_measures' => $unit_of_measures]);
    }

    public function create(Request $request): RedirectResponse
    {
        //TODO implement logic for saving article there ... (and test it of course for side effects)

        $result = $this->goodOrServiceService->store($request->except('_token'), request()->query('company'));

        if ($result['success']) {
            return redirect()->route('goods_and_services', ['company' => request()->query('company')])->with(
                ['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput();
        }
    }

    public function edit(): Factory|View|Application
    {
        $good_or_service = $this->goodOrServiceService->show(request()->query('good_or_service'))
        ['good_or_service']->toArray();
        $tax_categories = $this->taxCategoryService->index()['tax_categories'];

        $unit_of_measures = $this->unitOfMeasureService->index()['unit_of_measures'];

        return view('create_edit_good_or_service', ['tax_categories' => $tax_categories,
            'unit_of_measures' => $unit_of_measures, 'good_or_service' => $good_or_service]);
    }

    public function update(Request $request)
    {
        dd($request->except('_token'));

        //TODO Implement update method! (also fix and improve update method!!) -
        // connect good_and_service_details
    }
}
