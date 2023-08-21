<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
            return view('business_user_dashboard');

            // next thing is to save token in Laravel session with $user data!
            // add check for is_active account!
            // make check if user is administrator or business user!
        } else {
            return redirect()->route('login')->withErrors(['message' => $result['message']])->withInput();
        }
    }
}
