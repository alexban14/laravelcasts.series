<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Scopes\TenantScope;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

#[ScopedBy([TenantScope::class])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'photo',
        'department',
        'title',
        'status',
        'password',
        'tenant_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatarUrl():string
    {
        if($this->photo) {
            return Storage::disk('s3-public')->url($this->photo);
        }
        return '';
    }

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isHR(): bool
    {
        return $this->role == 'human Resources';
    }

    public function applicationUrl()
    {
        $applicationDoc = $this->application();

        if (!$applicationDoc) {
            return '#';
        }

        return url('/documents/' . $this->id . '/' . $applicationDoc->filename);
    }

    public function application()
    {
        return $this->documents()->firstWhere('type', 'application');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
