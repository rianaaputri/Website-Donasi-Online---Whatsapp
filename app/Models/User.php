<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
       
        'password',
        'phone',
        'address',
        'role',
        'is_active',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: User has many Campaigns
     */
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    /**
     * Relationship: User has many Donations
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Accessor: Check if user is admin
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Accessor: Check if user is regular user
     */
    public function getIsUserAttribute(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Accessor: Get total donations amount
     */
    public function getTotalDonatedAttribute(): float
    {
        // pastikan donations punya scopeSuccess()
        return (float) $this->donations()->success()->sum('amount');
    }

    /**
     * Accessor: Get total campaigns created
     */
    public function getTotalCampaignsAttribute(): int
    {
        return $this->campaigns()->count();
    }

    /**
     * Accessor: Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'user'  => 'Pengguna',
            default => ucfirst((string) $this->role),
        };
    }

    /**
     * Scope: Filter by role
     */
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope: Filter active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter verified users
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'user';
            }
            if (!isset($user->is_active)) {
                $user->is_active = true;
            }
        });
    }
}
