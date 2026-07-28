<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Target extends Model
{
    use HasFactory;

    protected $table = 'targets';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tahun'        => 'integer',
            'target'       => 'decimal:2',
            'provinsi_id'  => 'integer',
            'kabupaten_id' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope('rbac_isolation', function (Builder $builder) {
            if (!app()->runningInConsole() && Auth::check()) {

                /** @var \App\Models\User $user */
                $user = Auth::user();

                if (method_exists($user, 'isAdminDirektorat') && $user->isAdminDirektorat()) {
                    $builder->where(
                        $builder->qualifyColumn('direktorat_id'),
                        $user->direktorat_id
                    );
                
                }
            }
        });
    }

    // LOCAL SCOPES

    public function scopeByTahun(Builder $query, int $tahun): Builder
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeByWilayah(
        Builder $query,
        ?int $provinsiId = null,
        ?int $kabupatenId = null
    ): Builder {
        return $query
            ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
            ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId));
    }

    public function scopeByKomoditas(
        Builder $query,
        ?int $komoditasId = null
    ): Builder {
        return $query->when(
            $komoditasId,
            fn ($q) => $q->where('komoditas_id', $komoditasId)
        );
    }

    // RELASI
    public function direktorat(): BelongsTo
    {
        return $this->belongsTo(Direktorat::class);
    }

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function komoditas(): BelongsTo
    {
        return $this->belongsTo(Komoditas::class);
    }

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(Satuan::class);
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}