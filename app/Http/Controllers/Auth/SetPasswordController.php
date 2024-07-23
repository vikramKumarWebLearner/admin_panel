<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use Flash;
use Illuminate\Foundation\Auth\ResetsPasswords;

class SetPasswordController extends Controller
{

    use ResetsPasswords;

    /** @var  UserRepository */
    private $userRepository;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function showSetPasswordForm($token)
    {

        $users = $this->userRepository->getUsersByWhere('remember_token', $token)->pluck('email');

        if ($users->isNotEmpty()) {
            $email=null;
            if($users && $users[0]){
                $email = $users[0];
            }

            $credentials['email'] = $email = $users[0];
            $credentials['token'] = $token;

            if (is_null($user = $this->broker()->getUser($credentials))) {
                return view('auth.user-not-found');
            }

            if (! $this->broker()->tokenExists($user, $credentials['token'])) {
                return view('auth.expired-link');
            }

            return view('auth.emails.set-password-form', ['token' => $token, 'email' => $email]);
        } else {
            Flash::error('Invalid token or expired token!');
            return redirect(route('login'));
        }
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $matchedCount = $this->userRepository->getUsersDataByEmailTokenCount($request->email, $request->token);
        if($matchedCount){
            $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => null,
                    'email_verified_at' => Carbon::now()->copy(),
                    'status' => 'ACTIVE',
                ])->save();

                // You can add any additional logic here, such as logging in the user automatically.

                // For example, you can uncomment the line below to automatically log in the user after setting the password:
                auth()->login($user);
            });

            if ($response === Password::PASSWORD_RESET) {
                Flash::success('Your password has been set successfully.');
                return redirect(route('login'));
            } else {
                return back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
            }
        }else{
            Flash::error("Invalid token.");
        }
    }
}
