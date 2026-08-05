<?php

namespace App\Observers;

use App\Models\DashboardUpdateState;
use App\Models\Realisasi;

class RealisasiObserver
{
    public function created(Realisasi $realisasi): void
    {
        $this->recordChange();
    }

    public function updated(Realisasi $realisasi): void
    {
        $this->recordChange();
    }

    public function deleted(Realisasi $realisasi): void
    {
        $this->recordChange();
    }

    private function recordChange(): void
    {
        DashboardUpdateState::query()->updateOrCreate(
            ['id' => 1],
            ['last_realisasi_change_at' => now()]
        );
    }
}
