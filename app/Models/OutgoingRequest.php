<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\OutgoingRequest
 *
 * @property int $id
 * @property string $request_number
 * @property int $requested_by
 * @property string $status
 * @property string $purpose
 * @property string|null $notes
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property string|null $approval_notes
 * @property \Illuminate\Support\Carbon $requested_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $requestedBy
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OutgoingRequestItem> $items
 * @property-read int|null $items_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereApprovalNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereRequestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequest pending()

 * 
 * @mixin \Eloquent
 */
class OutgoingRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'request_number',
        'requested_by',
        'status',
        'purpose',
        'notes',
        'approved_by',
        'approved_at',
        'approval_notes',
        'requested_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'requested_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who requested.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Get the user who approved.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the items for the outgoing request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OutgoingRequestItem::class);
    }

    /**
     * Scope a query to only include pending requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}