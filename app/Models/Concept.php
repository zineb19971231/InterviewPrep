<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concept extends Model
{
    use SoftDeletes;

    protected $fillable = ['domain_id', 'title', 'explanation', 'difficulty', 'status'];

    protected function statusLabel(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => match ($this->status) {
                'to_review' => 'À revoir',
                'in_progress' => 'En cours',
                'mastered' => 'Maîtrisé',
                default => $this->status,
            },
        );
    }

    protected function difficultyLabel(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => match ($this->difficulty) {
                'junior' => 'Junior',
                'mid' => 'Mid',
                'senior' => 'Senior',
                default => $this->difficulty,
            },
        );
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function generatedQuestions(): HasMany
    {
        return $this->hasMany(GeneratedQuestion::class);
    }
}
