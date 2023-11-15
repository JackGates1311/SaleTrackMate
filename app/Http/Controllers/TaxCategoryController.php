<?php

namespace App\Http\Controllers;

use App\Models\TaxCategory;
use App\Services\TaxCategoryService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaxCategoryController extends Controller
{
    private TaxCategoryService $taxCategoryService;
    private UserService $userService;

    public function __construct(TaxCategoryService $taxCategoryService, UserService $userService)
    {
        $this->taxCategoryService = $taxCategoryService;
        $this->userService = $userService;
    }

    public function index(): Factory|View|Application
    {
        $tax_categories = $this->taxCategoryService->index();

        return view('manage_tax_categories', ['tax_categories' => $tax_categories,
            'editable' => false]);
    }

    public function create(Request $request): RedirectResponse
    {
        $result = $this->taxCategoryService->store($request->except('_token'),
            $this->userService->getUserIdWeb());

        return $this->loadTaxCategoriesPage($result);
    }

    public function update(Request $request): RedirectResponse
    {
        $request_array = $request->except('_token');
        $result = $this->taxCategoryService->update($request_array, $request_array['tax_category_id'],
            $this->userService->getUserIdWeb());

        return $this->loadTaxCategoriesPage($result);
    }

    public function delete(): RedirectResponse
    {
        $result = $this->taxCategoryService->destroy(request()->query('tax_category'),
            $this->userService->getUserIdWeb());

        return $this->loadTaxCategoriesPage($result);
    }

    public function loadTaxCategoriesPage(array $result): RedirectResponse
    {
        if ($result['success']) {
            return redirect()->route('tax_categories', ['company' => request()->query('company')])->with(
                ['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput();
        }
    }
}
