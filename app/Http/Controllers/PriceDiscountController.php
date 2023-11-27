<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PriceDiscountController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('manage_price_discounts', ['editable' => false]);
    }

    public function edit(): Factory|View|Application
    {
        return view('manage_price_discounts', ['editable' => true]);
    }

    public function update(Request $request)
    {
    }

    public function createView(): Factory|View|Application
    {
        return view('manage_price_discounts', ['editable' => true]);
    }

    public function create(Request $request)
    {

    }

    public function delete()
    {

    }
}
