<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }

    /**
     * Check if user has a specific role by slug.
     */
    public function hasRole(string $slug): bool
    {
        return $this->role?->slug === $slug;
    }

    /**
     * Check if user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user can edit contracts.
     */
    public function canEdit(): bool
    {
        return in_array($this->role?->slug, ['admin', 'editor']);
    }

    /**
     * Check if user can only view contracts.
     */
    public function isViewer(): bool
    {
        return $this->hasRole('viewer');
    }

    /**
     * Get the human-readable role name.
     */
    public function getRoleNameAttribute(): ?string
    {
        return $this->role?->nombre;
    }

    /**
     * Get the user's role slug (or 'none' if no role).
     */
    public function getRoleSlugAttribute(): string
    {
        return $this->role?->slug ?? 'none';
    }
}
