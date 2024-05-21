<?php

namespace App\Http\Controllers;

use App\Actions\RideAction;
use App\Http\Requests\RideRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RideController extends Controller
{
    /**
     * @param RideAction $rideAction
     */
    public function __construct(protected readonly RideAction $rideAction)
    {}

    /**
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $rides = $this->rideAction->getAll($request);

        if(!$rides) {
            return response()->json(['message' => 'No rides found or not permission to view'], 404);
        }

        return response()->json($rides, 200);
    }

    /**
     * @param RideRequest $request
     */
    public function store(RideRequest $request)
    {
        $ride = $this->rideAction->store($request);

        return response()->json($ride, 201);
    }

    /**
     * @param int $id
     * @return void
     */
    public function cancel($id)
    {
        $this->rideAction->cancel($id);

        return response()->json(['message' => 'Ride canceled successfully.'], 201);
    }

    /**
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $ride = $this->rideAction->show($id);

        return response()->json($ride);
    }
}
