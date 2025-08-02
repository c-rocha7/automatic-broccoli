<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponseAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_response_id',
        'question_text',
        'alternative_text',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function formResponse(): BelongsTo
    {
        return $this->belongsTo(FormResponse::class);
    }
}
