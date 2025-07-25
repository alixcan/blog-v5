<?php

namespace App\Models;

use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    protected function casts() : array
    {
        return [
            'is_approved' => 'datetime',
            'is_declined' => 'datetime',
        ];
    }

    #[Scope]
    public function pending(Builder $query) : void
    {
        $query
            ->whereNull('is_declined')
            ->whereNull('is_approved');
    }

    #[Scope]
    public function approved(Builder $query) : void
    {
        $query
            ->whereNotNull('is_approved')
            ->whereNull('is_declined');
    }

    #[Scope]
    public function declined(Builder $query) : void
    {
        $query
            ->whereNotNull('is_declined')
            ->whereNull('is_approved');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved() : bool
    {
        return null !== $this->is_approved && null === $this->is_declined;
    }

    public function isDeclined() : bool
    {
        return null !== $this->is_declined && null === $this->is_approved;
    }
}
