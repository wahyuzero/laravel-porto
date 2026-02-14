<?php

namespace App\Providers;

use App\Helpers\CdnHelper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        // Register @cdn('path') Blade directive
        Blade::directive('cdn', function ($expression) {
            return "<?php echo \App\Helpers\CdnHelper::asset($expression); ?>";
        });

        // Register @cdnv('path') for versioned CDN assets
        Blade::directive('cdnv', function ($expression) {
            return "<?php echo \App\Helpers\CdnHelper::versioned($expression); ?>";
        });
    }
}
