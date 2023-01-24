<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachments extends Model
{
    use HasFactory;
    protected $table = 'attachments';
    
    protected $fillable = [
        'path',
        'filename',
        'extension',
        'letter_id',
        'user_id',
    ];

    protected $appends = [
        'path_url',
    ];

        /**
     * @return BelongsTo
     */
    public function letter(): BelongsTo
    {
        return $this->belongsTo(Letter::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
