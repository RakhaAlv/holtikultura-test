<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Realisasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Hapus $with untuk mencegah Memory Leak pada Kueri Agregasi/Chart

    protected function casts(): array
    {
        return [
            'tahun'         => 'integer',
            'jumlah_output' => 'decimal:2',
            'anggaran'      => 'decimal:2',
            'provinsi_id'   => 'integer',
            'kabupaten_id'  => 'integer',
            'kecamatan_id'  => 'integer',
            'desa_id'       => 'integer',
        ];
    }

    protected static function booted(): void
    {
        // Proteksi RBAC Isolation (Aman untuk CLI / Background Jobs)
        static::addGlobalScope('rbac_isolation', function (Builder $builder) {
            if (!app()->runningInConsole() && Auth::check()) {
                /** @var \App\Models\User $user */
                $user = Auth::user();

                if (method_exists($user, 'isAdminDirektorat') && $user->isAdminDirektorat()) {
                    $builder->where($builder->qualifyColumn('direktorat_id'), $user->direktorat_id);
                } 
            }
        });
    }

    // --- LOCAL SCOPES UNTUK AGREGASI DASHBOARD ---

    public function scopeByTahun(Builder $query, int $tahun): Builder
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeByKomoditas(Builder $query, ?int $komoditasId = null): Builder
    {
        return $query->when($komoditasId, fn ($q) => $q->where('komoditas_id', $komoditasId));
    }

    public function scopeRekapPerDirektorat(Builder $query, int $tahun): Builder
    {
        return $query->where('tahun', $tahun)
                    ->selectRaw('direktorat_id, COALESCE(SUM(anggaran), 0) as total_anggaran, COALESCE(SUM(jumlah_output), 0) as total_output, COUNT(id) as total_kegiatan')
                    ->groupBy('direktorat_id');
    }

    public function scopeRekapPerProvinsi(Builder $query, int $tahun): Builder
    {
        return $query->where('tahun', $tahun)
                    ->selectRaw('provinsi_id, COALESCE(SUM(anggaran), 0) as total_anggaran, COALESCE(SUM(jumlah_output), 0) as total_output')
                    ->groupBy('provinsi_id');
    }

    public function direktorat(): BelongsTo { return $this->belongsTo(Direktorat::class); }
    public function kegiatan(): BelongsTo { return $this->belongsTo(Kegiatan::class); }
    public function komoditas(): BelongsTo { return $this->belongsTo(Komoditas::class); }
    public function satuan(): BelongsTo { return $this->belongsTo(Satuan::class); }
    public function provinsi(): BelongsTo { return $this->belongsTo(Provinsi::class); }
    public function kabupaten(): BelongsTo { return $this->belongsTo(Kabupaten::class); }
    public function kecamatan(): BelongsTo { return $this->belongsTo(Kecamatan::class); }
    public function desa(): BelongsTo { return $this->belongsTo(Desa::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
}