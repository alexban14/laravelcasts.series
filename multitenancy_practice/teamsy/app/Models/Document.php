<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([TenantScope::class])]
class Document extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'type',
        'user_id',
        'filename',
        'extension',
        'size',
        'tenant_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
