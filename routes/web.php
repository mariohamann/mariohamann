<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);


// The route to the RSS feed.
Route::statamic('/feed/articles', 'feed/feed', [
    'layout' => null,
    'content_type' => 'application/xml',
]);

Route::statamic('open-graph/home', 'articles/open_graph', [
    'layout' => null,
]);

Route::statamic('open-graph/{article}', 'articles/open_graph', [
    'layout' => null,
]);
