<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class InvoiceController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('invoices');
    }
}
