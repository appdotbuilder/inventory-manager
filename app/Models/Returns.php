<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Returns
 *
 * @property int $id
 * @property string $return_number
 * @property int $product_id
 * @property int $quantity
 * @property string $reason
 * @property string $condition
 * @property string $action
 * @property string|null $notes
 * @property int $returned_by
 * @property \Illuminate\Support\Carbon $returned_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $returnedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Returns newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Returns newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Returns query()
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereReturnNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereReturnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereReturnedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Returns whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Returns extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'return_number',
        'product_id',
        'quantity',
        'reason',
        'condition',
        'action',
        'notes',
        'returned_by',
        'returned_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'returned_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product that owns the return.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who made the return.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function returnedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}