<?php

namespace Ajifatur\Campusnet\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Ajifatur\Campusnet\Models\User;
use Ajifatur\Campusnet\Models\Socmed;

class LoginController extends \App\Http\Controllers\Controller
{
    /**
     * Show login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // View
        return view('campusnet::auth/login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ]);
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('auth.login');
    }
    
    /**
     * Redirect to provider.
     *
     * @param  string $provider
     * @return \Laravel\Socialite\Facades\Socialite
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @param  string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect()->route('admin.dashboard');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  object $user
     * @param  string $provider
     * @return \Ajifatur\Campusnet\Models\User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = Socmed::where('provider_id','=',$user->getId())->where('provider_name','=',$provider)->first();

        if($authUser) {
            return $authUser;
        }
        else {
            $data = User::where('email','=',$user->getEmail())->first();

            if(!$data) {
				// Save the user
                $data = new User;
                $data->role_id = role('learner');
                $data->name = $user->getName();
                $data->username = $user->getNickname();
                $data->email = $user->getEmail();
				$data->photo = $user->getAvatar();
				$data->status = 1;
				$data->email_verified = 1;
                $data->save();
            }
				
            // Save the socmed
            $socmed = new Socmed;
            $socmed->user_id = $data->id;
            $socmed->provider_id = $user->getId();
            $socmed->provider_name = $provider;
            $socmed->save();

            return $data;
        }
    }
}
