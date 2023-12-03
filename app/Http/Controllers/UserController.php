<?php

namespace App\Http\Controllers;

use App\Enums\AccountType;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        session(['account_edit' => false]);
        session(['account' => true]);

        //how to add param in url there?

        return view('account', ['companies' => $this->userService->getUserCompanies()]);
    }

    public function edit(): View
    {
        session(['account_edit' => true]);
        return view('account', ['companies' => $this->userService->getUserCompanies()]);
    }

    public function register(Request $request): RedirectResponse|View
    {
        $result = $this->userService->register($request->except('_token'));

        // add check if password and repeat password is the same!
        // implement server side validations in more advanced way!

        if ($result['success']) {
            return redirect()->route('login')->with(['success' => $result['message']]);
        } else {
            return redirect()->route('register')->withErrors(['error' => $result['error']])->withInput();
        }
    }

    public function login(Request $request): RedirectResponse|View
    {
        $result = $this->userService->login($request->except('_token'));

        if ($result['success']) {
            session(['user_data' => $result['user']]);
            return redirect()->route('invoices')->with(['user' => $result['user']]);

            // make check if user is administrator or business user!
        } else {
            return redirect()->route('login')->withErrors(['message' => $result['message']])->withInput();
        }
    }

    public function logout(): Redirector|Application|RedirectResponse
    {
        $this->userService->logout();

        session()->forget('user_data');

        return redirect('/');
    }

    public function manageRequests(): Factory|View|Application
    {
        $result = $this->userService->getUserData($this->userService->getUserIdWeb());

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            $user_registration_requests = $this->userService->getRegistrationRequests(
                $this->userService->getUserIdWeb())['user_registration_requests'];
            return view('manage_user_registration_requests', ['user_registration_requests' =>
                $user_registration_requests]);
        } else {
            return view('permission_denied');
        }
    }

    public function updateRequestStatus(Request $request): RedirectResponse
    {
        $request_array = $request->except('_token');

        $result = $this->userService->updateApprovalStatus($request_array, $request_array['user_registration_request'],
            $this->userService->getUserIdWeb());

        if ($result['success']) {
            return redirect()->route('user_registration_requests',
                ['company' => request()->query('company')])->with(['message' => $result['message']]);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }
}
