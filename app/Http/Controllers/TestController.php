<?php

namespace App\Http\Controllers;

use App\Remote;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\SSH;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;

class TestController extends Controller
{
    //
    public function index()
    {
        return view('welcome');
    }

    public function test_ssh()
    {
        // connect ssh
        // \SSH::run("less /etc/passwd", function ($line) {
        //     echo $line . PHP_EOL;
        // });

        // // break line php
        // echo "\n";

        // \SSH::into('mikrotik')->run("ip add print", function ($line) {
        //     echo $line . PHP_EOL;
        // });

        // print information about mikrotik config ssh
        // echo "\n";
        // print_r(\SSH::into('mikrotik')->get());
        // echo "\n";

        // \SSH::into('production')->run("ip add print", function ($line) {
        //     echo $line . PHP_EOL;
        // });


        // $remotePath = 'test.txt';
        // $localPath = 'D:test.txt';
        // // \SSH::into('testsat')->get($remotePath, $localPath);

        // $contents = \SSH::into('production')->getString($remotePath);
        // echo $contents;
        
        $tes = Config::get('remote.connections.aaaaa');
        // dd($tes);
        // getremote
        $connection = \SSH::into('aaaaa');
        $config = config('remote.connections.aaaaa');
        \SSH::into('aaaaa')->run("ls -al", function ($line) {
            dd( $line . PHP_EOL);
        });
        
        // print_r($connection);
        $connection = new \phpseclib\Net\SSH2($config['host']);

        if (!$connection->login($config['username'], $config['password'])) {
            throw new Exception('Cannot connect to server');
        }
        // print_r($config);




        // $contents = SSH::into('staging')->getString($remotePath);
    }

    public function test_insert_data(){
        $remote = new Remote();

        $remote->name = 'test';
        $remote->host = 'example.com';
        $remote->username = 'ussername';
        $remote->password = Crypt::encryptString('Passwowrd');
        $remote->key = '';
        $remote->keyphrase = '';
        $remote->agent = '';
        $remote->timeout = '';
        $remote->port = '22';
        $remote->save();
    }

    public function show_data(){
        $remote = Remote::all();
        try {
            $decrypted = Crypt::decryptString($remote[0]->password);
            dd($decrypted);
        } catch (DecryptException $e) {
            dd($e);
        }
      
    }
}
