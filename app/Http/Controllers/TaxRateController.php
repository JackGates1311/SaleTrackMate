<?php

namespace App\Http\Controllers;

use App\Services\TaxRateService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    private TaxCategoryController $taxCategoryController;
    private TaxRateService $taxRateService;
    public UserService $userService;

    public function __construct(TaxCategoryController $taxCategoryController, UserService $userService,
                                TaxRateService        $taxRateService)
    {
        $this->taxCategoryController = $taxCategoryController;
        $this->taxRateService = $taxRateService;
        $this->userService = $userService;
    }

    public function create(Request $request): RedirectResponse
    {
        $result = $this->taxRateService->store($request->toArray()['tax_rate'],
            $this->userService->getUserIdWeb(), $request->toArray()['tax_category_id'] ?? '');

        return $this->taxCategoryController->loadTaxCategoriesPage($result);
    }

    public function edit(): Factory|View|Application
    {
        $tax_rate = $this->taxRateService->show(request()->query('tax_rate'))['tax_rate']->toArray();

        return view('edit_tax_rate', ['tax_rate' => $tax_rate]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request_array = $request->except('_token');

        $result = $this->taxRateService->update($request_array['tax_rate'], request()->query('tax_rate'),
            $this->userService->getUserIdWeb());

        if ($result['success']) {
            return redirect()->route('tax_categories', ['company' => request()->query('company')])->with(
                ['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput();
        }
    }

    public function delete(): RedirectResponse
    {
        $result = $this->taxRateService->destroy(request()->query('tax_rate'), $this->userService->getUserIdWeb());

        if ($result['success']) {
            return redirect()->route('tax_categories', ['company' => request()->query('company')])->with(
                ['message' => $result['message']]);
        } else {
            return redirect()->route('tax_categories', ['company' => request()->query('company')])->
            withErrors(['message' => $result['message']]);
        }
    }
}
