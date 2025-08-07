<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Repair
 *
 * @property int $id
 * @property string $repair_number
 * @property int $product_id
 * @property int $quantity
 * @property string $issue_description
 * @property string $status
 * @property string|null $estimated_cost
 * @property string|null $actual_cost
 * @property \Illuminate\Support\Carbon|null $estimated_completion
 * @property \Illuminate\Support\Carbon|null $actual_completion
 * @property string|null $repair_notes
 * @property string|null $completion_notes
 * @property int|null $assigned_to
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User|null $assignedTo
 * @property-read \App\Models\User $createdBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Repair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair query()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereActualCompletion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereActualCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereCompletionNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereEstimatedCompletion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereEstimatedCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereIssueDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereRepairNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereRepairNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair pending()

 * 
 * @mixin \Eloquent
 */
class Repair extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'repair_number',
        'product_id',
        'quantity',
        'issue_description',
        'status',
        'estimated_cost',
        'actual_cost',
        'estimated_completion',
        'actual_completion',
        'repair_notes',
        'completion_notes',
        'assigned_to',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'estimated_completion' => 'date',
        'actual_completion' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product that owns the repair.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user assigned to the repair.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who created the repair.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include pending repairs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}