<?php

namespace App\Providers;

use App\Models\DashboardUpdateState;
use App\Models\Realisasi;
use App\Observers\RealisasiObserver;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Realisasi::observe(RealisasiObserver::class);

        View::composer('partials.navbar', function ($view) {
            $lastUpdated = DashboardUpdateState::query()
                ->whereKey(1)
                ->value('last_realisasi_change_at');

            $carbonDate = $lastUpdated
                ? Carbon::parse($lastUpdated)
                : Carbon::create(2026, 7, 7, 0, 0, 0, 'Asia/Jakarta');

            $carbonDate->setTimezone('Asia/Jakarta')->locale('id');

            $view->with(
                'lastUpdatedData',
                $carbonDate->translatedFormat('d F Y • H:i').' WIB'
            );
        });
    }
}
