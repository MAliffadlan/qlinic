<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    public const STATUS_WAITING = 'waiting';

    public const STATUS_CALLING = 'calling';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_SKIPPED = 'skipped';

    public const STATUSES = [
        self::STATUS_WAITING,
        self::STATUS_CALLING,
        self::STATUS_COMPLETED,
        self::STATUS_SKIPPED,
    ];

    public const TRANSITIONS = [
        self::STATUS_WAITING => [self::STATUS_CALLING, self::STATUS_COMPLETED, self::STATUS_SKIPPED],
        self::STATUS_CALLING => [self::STATUS_COMPLETED, self::STATUS_SKIPPED],
        self::STATUS_COMPLETED => [],
        self::STATUS_SKIPPED => [],
    ];

    protected $fillable = [
        'service_id',
        'user_id',
        'queue_number',
        'status',
        'date',
    ];

    public function canTransitionTo(string $status): bool
    {
        return in_array($status, self::TRANSITIONS[$this->status] ?? [], true);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
