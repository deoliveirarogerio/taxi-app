<?php

namespace App\Actions;

use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class RideAction
{
    const PAGINATE_LIMIT = 5;

    /**
     * @param Ride $ride
     */
    public function __construct(protected readonly Ride $ride)
    {}

    /**
     * @param Request $request
     * @return void
     */
    public function getAll(Request $request)
    {
        $limit = $request->get('limit', self::PAGINATE_LIMIT);

        return $this->getUser()->rides()->paginate($limit);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $ride = $this->getUser()->rides()->create([
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location
        ]);

        //notification to driver

        return $ride;
    }

    /**
     * @param integer $id
     * @return void
     */
    public function show(int $id)
    {
        return $this->getUser()->rides()->where('id', $id)->firstOrFail();
    }

    /**
     * @param integer $id
     * @return void
     */
    public function cancel(int $id)
    {
        $ride = $this->getUser()->rides()->where('id', $id)->firstOrFail();

        if (!in_array($ride->status, [StatusEnum::requested->value, StatusEnum::accepted->value])) {
            throw ValidationException::withMessages(['error_status' => 'Ride status is not valid']);
        }

        $ride->update(['status' => StatusEnum::canceled->value]);

        // notification user and driver

        return true;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return auth()->user();
    }
}