<?php

namespace App\Http\Controllers;

use App\Models\GoodOrService;
use App\Services\PriceDiscountService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PriceDiscountController extends Controller
{
    private PriceDiscountService $priceDiscountService;

    public function __construct(PriceDiscountService $priceDiscountService)
    {
        $this->priceDiscountService = $priceDiscountService;
    }

    public function index(): Factory|View|Application
    {
        $price_discounts = GoodOrService::find(request()->query('good_or_service'))->priceDiscounts;
        return view('manage_price_discounts', ['price_discounts' => $price_discounts, 'editable' => false]);
    }

    public function edit(): Factory|View|Application
    {
        $price_discount = $this->priceDiscountService->show(request()->query('price_discount'))['price_discount']->
        toArray();
        $price_discounts[0] = $price_discount;

        return view('manage_price_discounts', ['editable' => true, 'price_discounts' => $price_discounts]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request_array = $request->toArray();

        $result = $this->priceDiscountService->update($request_array['price_discount'], $request['price_discount_id']);

        return $this->loadManagePriceDiscountsPage($result);
    }

    public function createView(): Factory|View|Application
    {
        return view('manage_price_discounts', ['editable' => true]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request_array = $request->except('_token');
        $result = $this->priceDiscountService->store($request_array['price_discount'],
            $request_array['good_or_service']);

        return $this->loadManagePriceDiscountsPage($result);
    }

    public function delete(): RedirectResponse
    {
        $result = $this->priceDiscountService->destroy(request()->query('price_discount'));

        return $this->loadManagePriceDiscountsPage($result);
    }

    private function loadManagePriceDiscountsPage(array $result): RedirectResponse
    {
        if ($result['success']) {
            return redirect()->route('price_discounts', ['company' => request()->query('company'),
                'good_or_service' => request()->query('good_or_service')])->with(['message' =>
                $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput();
        }
    }
}
