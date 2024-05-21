<?php 

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthAction
{
    /**
     * @param User $user
     */
    public function __construct(protected readonly User $user)
    {}

    /**
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $user = $this->user->create([
            'name' => request('name'),
            'email' => request('email'),
            'email_verified_at' => now(),
            'password' => bcrypt($request->password),
            'remenber_token' => Str::random(10),
        ]);

        return $user;
    }
}