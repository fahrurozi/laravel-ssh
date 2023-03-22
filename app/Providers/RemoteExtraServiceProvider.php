<?php

namespace App\Providers;

use App\Remote;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;

class RemoteExtraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            config_path('remote_extra.php'),
            'remote.connections'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $newConnection = [
            'host'      => '192.168.69.1',
            'username'  => 'admin',
            'password' => '',
            'key'       => '',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 10,
        ];

        $newConnection2 = [
            'host'      => '192.168.69.1',
            'username'  => 'admin',
            'password' => '',
            'key'       => '',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 10,
        ];

        $remote_lisst = Remote::all();
        foreach($remote_lisst as $remote){
            $newConnectionDb = [
                'host'      => $remote->host,
                'username'  => $remote->username,
                'password' => Crypt::decryptString($remote->password),
                'key'       => '',
                'keytext'   => '',
                'keyphrase' => '',
                'agent'     => '',
                'timeout'   => 10,
            ];
            Config::set('remote.connections.'.$remote->name, $newConnectionDb);
        }
    
        // Config::set('remote.connections.new_connection', $newConnection);
        // Config::set('remote.connections.new_connection2', $newConnection2);
    }
}
