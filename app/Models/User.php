<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'password_is_default',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_is_default' => 'boolean',
        ];
    }

    public function lendings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Lending::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOperator(): bool
    {
        return in_array($this->role, ['operator', 'staff'], true);
    }

    /** Plain-text default password rule: first 4 chars of email local-part + user id */
    public static function defaultPasswordPlain(self $user): string
    {
        $local = strtolower(strtok($user->email, '@') ?: '');
        $prefix = substr($local, 0, 4);
        $prefix = str_pad($prefix, 4, 'x');

        return $prefix.$user->id;
    }
}
