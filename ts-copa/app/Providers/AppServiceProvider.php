<?php

namespace App\Providers;

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
        // @flag('br') → <span class="fi fi-br"></span>
        Blade::directive('flag', function ($code) {
            return "<?php echo '<span class=\"fi fi-' . e($code) . '\"></span>'; ?>";
        });
    }
}
