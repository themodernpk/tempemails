<?php

Route::group(['middleware' => 'web', 'prefix' => 'tempemails', 'namespace' => 'Modules\TempEmails\Http\Controllers'], function()
{
    Route::get('/', 'TempEmailsController@index');
});
