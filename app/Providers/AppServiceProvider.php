<?php
 
 namespace App\Providers;
 
 use Illuminate\Support\ServiceProvider;
 use Illuminate\Support\Facades\View;
 use App\Models\Target;
 use App\Models\Realisasi;
 use Carbon\Carbon;
 
 class AppServiceProvider extends ServiceProvider
 {
     /**
      * Register any application services.
      */
     public function register(): void
     {
         //
     }
 
     /**
      * Bootstrap any application services.
      */
     public function boot(): void
     {
         View::composer('partials.navbar', function ($view) {
             $latestTarget = Target::max('updated_at');
             $latestRealisasi = Realisasi::max('updated_at');
 
             $lastUpdated = null;
             if ($latestTarget && $latestRealisasi) {
                 $lastUpdated = max($latestTarget, $latestRealisasi);
             } elseif ($latestTarget) {
                 $lastUpdated = $latestTarget;
             } elseif ($latestRealisasi) {
                 $lastUpdated = $latestRealisasi;
             }
 
             if ($lastUpdated) {
                 $carbonDate = Carbon::parse($lastUpdated);
                 $carbonDate->setLocale('id');
                 $formattedDate = $carbonDate->translatedFormat('d F Y • H:i') . ' WIB';
             } else {
                 $formattedDate = '-';
             }
 
             $view->with('lastUpdatedData', $formattedDate);
         });
     }
 }
