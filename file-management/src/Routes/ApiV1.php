<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use MService\FileManagement\Actions\DownloadFile;
use MService\FileManagement\Actions\GetFiles;
use MService\FileManagement\Actions\UploadFile;

/** @var Router $route */
try {
    $route = app()->make(Router::class);
} catch (BindingResolutionException $e) {
    abort(500, $e->getMessage());
}

$route->group(['prefix' => 'files', 'as' => 'file.'], function (Router $route) {
    $route->get('/', GetFiles::class)->name('index');
    $route->post('/', UploadFile::class)->name('store');
    $route->get('{file}/download', DownloadFile::class)->name('download');
});
