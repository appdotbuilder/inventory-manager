<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OutgoingRequestItem
 *
 * @property int $id
 * @property int $outgoing_request_id
 * @property int $product_id
 * @property int $requested_quantity
 * @property int|null $approved_quantity
 * @property int|null $fulfilled_quantity
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OutgoingRequest $outgoingRequest
 * @property-read \App\Models\Product $product
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereApprovedQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereFulfilledQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereOutgoingRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereRequestedQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingRequestItem whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class OutgoingRequestItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'outgoing_request_id',
        'product_id',
        'requested_quantity',
        'approved_quantity',
        'fulfilled_quantity',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requested_quantity' => 'integer',
        'approved_quantity' => 'integer',
        'fulfilled_quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the outgoing request that owns the item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outgoingRequest(): BelongsTo
    {
        return $this->belongsTo(OutgoingRequest::class);
    }

    /**
     * Get the product that owns the item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}