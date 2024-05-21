<?php

namespace App\Enums;

enum StatusEnum: string
{
    case requested = 'requested';
    case accepted = 'accepted';
    case completed = 'completed';
    case canceled = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::requested => 'Requested',
            self::accepted => 'Accepted',
            self::completed => 'Completed',
            self::canceled => 'Canceled',
        };
    }

    public function isAccepted(): bool
    {
        return $this === self::accepted;
    }

    public function isCompleted(): bool
    {
        return $this === self::completed;
    }

    public function isCanceled(): bool
    {
        return $this === self::canceled;
    }

    public function isRequested(): bool
    {
        return $this === self::requested;
    }
}