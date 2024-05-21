<?php 

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;

class UserAction
{
    const PAGINATE_LIMIT = 5;

    /**
     * @param User $user
     */
    public function __construct(protected readonly User $user)
    {}

    /**
     * @param Request $request
     * @return void
     */
    public function getAll(Request $request)
    {
        $limit = $request->get('limit', self::PAGINATE_LIMIT);
        
        return User::paginate($limit);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $user = $request->all();

        return User::create($user);
    }

    /**
     * @param string $id
     * @return void
     */
    public function show(string $id)
    {
        return User::findOrFail($id);
    }  

    /**
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return $user;
    }

    /**
     * @param string $id
     * @return void
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        
        return $user;
    }
}