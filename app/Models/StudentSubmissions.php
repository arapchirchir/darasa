<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentSubmissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignments_id',
        'user_id',
        'upload_file',
    ];

    /**
     * Get the user that owns the StudentSubmissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the assignment associated with the StudentSubmissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assignment(): HasOne
    {
        return $this->hasOne(Assignments::class, 'id', 'assignments_id');
    }
}
