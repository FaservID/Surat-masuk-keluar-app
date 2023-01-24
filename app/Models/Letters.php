<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Letters extends Model
{
    use HasFactory;

    protected $table = 'letters';
    protected $fillable = [
        'reference_number',
        'agenda_number',
        'from',
        'to',
        'letter_date',
        'received_date',
        'description',
        'note',
        'type',
        'classification_code',
        'user_id',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'received_date' => 'date',
    ];

    protected $appends = [
        'formatted_letter_date',
        'formatted_received_date',
        'formatted_created_at',
        'formatted_updated_at',
    ];

        /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classifications::class, 'classification_code', 'code');
    }

    /**
     * @return HasMany
     */
    public function dispositions(): HasMany
    {
        return $this->hasMany(Disposition::class, 'letter_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachments::class, 'letter_id', 'id');
    }
}
