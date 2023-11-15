<?php

namespace App\Http\Controllers;

use App\Services\TaxRateService;
use App\Services\UserService;
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
            $this->userService->getUserIdWeb(), $request->toArray()['tax_category_id']);

        return $this->taxCategoryController->loadTaxCategoriesPage($result);
    }
}
