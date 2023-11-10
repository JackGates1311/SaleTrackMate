<?php

namespace App\Http\Controllers;

use App\Services\UnitOfMeasureService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UnitOfMeasureController extends Controller
{
    private UnitOfMeasureService $unitOfMeasureService;
    private UserService $userService;

    public function __construct(UnitOfMeasureService $unitOfMeasureService, UserService $userService)
    {
        $this->unitOfMeasureService = $unitOfMeasureService;
        $this->userService = $userService;
    }

    public function index(): Factory|View|Application
    {
        $unit_of_measures = $this->unitOfMeasureService->index()['unit_of_measures'];

        return view('manage_unit_of_measures', ['unit_of_measures' => $unit_of_measures, 'editable' => false]);
    }

    public function create(Request $request): RedirectResponse
    {
        $result = $this->unitOfMeasureService->store($request->except('_token'),
            $this->userService->getUserIdWeb());

        return $this->loadUnitOfMeasuresPage($result);
    }

    public function edit(): Factory|View|Application
    {
        $unit_of_measure = $this->unitOfMeasureService->show(request()->query('unit_of_measure'))
        ['unit_of_measure']->toArray();

        $unit_of_measures[0] = $unit_of_measure;

        return view('manage_unit_of_measures', ['unit_of_measures' => $unit_of_measures,
            'editable' => true]);
    }

    public function update(Request $request): RedirectResponse
    {
        $requestArray = $request->except('_token');
        $result = $this->unitOfMeasureService->update($requestArray, $requestArray['unit_of_measure'],
            $this->userService->getUserIdWeb());

        return $this->loadUnitOfMeasuresPage($result);
    }

    public function delete(): RedirectResponse
    {
        $result = $this->unitOfMeasureService->destroy(request()->query('unit_of_measure'),
            $this->userService->getUserIdWeb());

        return $this->loadUnitOfMeasuresPage($result);
    }

    public function loadUnitOfMeasuresPage(array $result): RedirectResponse
    {
        if ($result['success']) {
            return redirect()->route('unit_of_measures', ['company' => request()->query('company')])->with(
                ['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']])->withInput();
        }
    }
}
