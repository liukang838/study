<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //sql日志
        \DB::listen(function (QueryExecuted $query) {
            $sqlWithPlaceholders = str_replace(['%', '?'], ['%%', '%s'], $query->sql);
            $bindings = $query->connection->prepareBindings($query->bindings);
            $pdo = $query->connection->getPdo();
            $sql = vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));
            \Log::info('SQLLOG>>' . $sql . '>>' . $query->time . '>>');
        });
    }
}
