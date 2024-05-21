<?php

namespace App\Http\Controllers;

use App\Actions\UserAction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param UserAction $userAction
     */
    public function __construct(protected readonly UserAction $userAction)
    {}

    /**
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $users = $this->userAction->getAll($request);

        return response()->json($users, 200);
    }

    /**
     * @param string $id
     * @return void
     */
    public function show(string $id)
    {
        $user = $this->userAction->show($id);

        return response()->json($user, 200);
    }

    /**
     * @param Request $request
     */
    public function update(Request $request, string $id)
    {
        $user = $this->userAction->update($request, $id);

        return response()->json($user, 201);
    }

    /**
     * @return void
     */
    public function destroy($id)
    {
        $this->userAction->destroy($id);

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}
