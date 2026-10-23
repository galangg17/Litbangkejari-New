<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\FormTextHelper;

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
        // Blade directive untuk format teks kuesioner (Tebal, Miring, Garis Bawah)
        Blade::directive('formText', function ($expression) {
            return "<?php echo \App\Helpers\FormTextHelper::format($expression); ?>";
        });
    }
}
