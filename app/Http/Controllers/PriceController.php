<?php

namespace App\Http\Controllers;

use App\Models\GoodOrService;
use App\Services\PriceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class PriceController extends Controller
{
    private PriceService $priceService;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function index(): Factory|View|Application
    {
        $prices = GoodOrService::find(request()->query('good_or_service'))->prices;
        return view('manage_prices', ['editable' => false, 'prices' => $prices]);
    }

    public function edit(): Factory|View|Application
    {
        $price = $this->priceService->show(request()->query('price'))['price']->toArray();
        $prices[0] = $price;

        return view('manage_prices', ['editable' => true, 'prices' => $prices]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request_array = $request->except('_token');

        $result = $this->priceService->update($request_array['price'], $request_array['price_id']);

        return $this->loadManagePricesPage($result);
    }

    public function createView(): Factory|View|Application
    {
        return view('manage_prices', ['editable' => true]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request_array = $request->except('_token');

        $result = $this->priceService->store($request_array['price'], request()->query('good_or_service'));

        return $this->loadManagePricesPage($result);
    }

    public function delete(): RedirectResponse
    {
        $result = $this->priceService->destroy(request()->query('price'));

        return $this->loadManagePricesPage($result);
    }

    public function loadManagePricesPage(array $result): RedirectResponse
    {
        if ($result['success']) {
            return redirect()->route('prices', ['company' => request()->query('company'),
                'good_or_service' => request()->query('good_or_service')])->with(['message' =>
                $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput();
        }
    }
}
