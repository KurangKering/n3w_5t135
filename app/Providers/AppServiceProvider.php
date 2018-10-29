<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Validator::extend('uniqueMahasiswaIdNim', function($attr, $value, $parameters, $validator){
        $count = DB::table('pembayaran_semesters')
        ->where('semester', $value)
        ->where('mahasiswa_id', $parameters[0])
        ->count();
        return $count === 0;

    }, "the semester field is unique");
   }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
