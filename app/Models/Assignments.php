<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assignments extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'due_date',
        'title',
        'description',
    ];

    /**
     * Get all of the submissions for the Assignments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(StudentSubmissions::class);
    }

    /**
     * Get the grade associated with the Assignments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grade(): HasOne
    {
        return $this->hasOne(Grading::class, 'assignments_id');
    }
}
