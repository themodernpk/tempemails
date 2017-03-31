<?php
/*
|--------------------------------------------------------------------------
| Cron Jobs
|--------------------------------------------------------------------------
*/
Route::group(
    [
        'middleware' => ['web'],
        'prefix' => 'cron',
        'namespace' => 'Modules\TempEmails\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::any('/per/minute', 'CronController@perMinute')
            ->name('te.cron.per.minute');
        //------------------------------------------------
        Route::any('/per/minute', 'CronController@perMinute')
            ->name('te.cron.per.minute');
        //------------------------------------------------
        Route::any('/auth/pusher', 'CronController@authPusher')
            ->name('te.pusher');
        //------------------------------------------------
        Route::any('/clean/database', 'CronController@cleanDatabase')
            ->name('te.clean.database');
        //------------------------------------------------
    });
/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::group(
    [
        'middleware' => ['web'],
        'namespace' => 'Modules\TempEmails\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::any('/', 'TempEmailsController@index')
            ->name('te.index');
        //------------------------------------------------
        Route::any('/redirect', 'TempEmailsController@checkCookies')
            ->name('te.app.redirect');
        //------------------------------------------------
        Route::any('/email/iframe/{encrypted_id}', 'TempEmailsController@emailiFrame')
            ->name('te.email.iframe');

    });



/*
|--------------------------------------------------------------------------
| Inbox Prefixed
|--------------------------------------------------------------------------
*/
Route::group(
    [
        'middleware' => ['web'],
        'prefix'     => '{inbox?}',
        'namespace' => 'Modules\TempEmails\Http\Controllers'
    ],
    function () {

        Route::any('/apps', 'TempEmailsController@apps')
            ->name('te.apps');
        //------------------------------------------------
        Route::any('/accounts', 'TempEmailsController@accounts')
            ->name('te.account');
        //------------------------------------------------
        Route::any('/account/list', 'TempEmailsController@accountList')
            ->name('te.account.list');
        //------------------------------------------------
        Route::any('/email/list', 'TempEmailsController@emailList')
            ->name('te.email.list');
        //------------------------------------------------
        Route::any('/email/details', 'TempEmailsController@emailDetails')
            ->name('te.email.details');
        //------------------------------------------------

        //------------------------------------------------
        Route::any('/generate/account', 'TempEmailsController@generateAccount')
            ->name('te.generate.account');
        //------------------------------------------------
        Route::any('/delete/account', 'TempEmailsController@deleteAccount')
            ->name('te.delete.account');
        //------------------------------------------------
        Route::any('/mark/all/read', 'TempEmailsController@markAllAsRead')
            ->name('te.mark.all.read');
        //------------------------------------------------
        Route::any('/delete/all/emails', 'TempEmailsController@deleteAllEmails')
            ->name('te.delete.all.emails');
        //------------------------------------------------
    });

        //------------------------------------------------



/*
|--------------------------------------------------------------------------
| BD Test Reports
|--------------------------------------------------------------------------
*/
/*Route::group(
    [
        'middleware' => [ 'web', 'core.backend' ],
        'prefix'     => 'backend/gn',
        'namespace'  => 'Modules\General\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/labels', 'LabelController@index' )
            ->name( 'gn.labels' );


        //------------------------------------------------
    });*/