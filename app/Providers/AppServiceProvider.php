<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        // Bagikan jumlah pendaftar pending ke seluruh tampilan admin untuk badge notifikasi sidebar
        View::composer(['admin.*', 'dashboard.admin'], function ($view) {
            $adminCabang = Auth::user()->id_cabang ?? null;
            $sidebarPendingCount = DB::table('pendaftaran_baru')
                ->where('status_pendaftaran', 'pending')
                ->when($adminCabang, function($q) use ($adminCabang) {
                    return $q->where('id_cabang', $adminCabang);
                })
                ->count();
            $view->with('sidebarPendingCount', $sidebarPendingCount);
        });
    }
}
