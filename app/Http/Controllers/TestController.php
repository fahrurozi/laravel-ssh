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

        // $tes = Config::get('remote.connections');
        // dd($tes);
        // getremote
        // $connection = \SSH::into('mikrotik');
        // $config = config('remote.connections.mikrotik');
        try {
            \SSH::into('test')->run("ip address", function ($line) {
                dump($line . PHP_EOL);
                echo "<br>";
                $rep = (str_replace("\r\n", '!', $line));
                dump($rep);
                echo "<br>";
                $array = explode('!', $rep);
                $ind1 = explode('-', $array[0]);
                $ind2 = explode(' ', preg_replace('!\s+!', ' ', $array[1]));
                $ind3 = explode(' ', preg_replace('!\s+!', ' ', $array[2]));
                $array[0] = $ind1;
                $ind2 = array_filter($ind2, fn ($value) => !is_null($value) && $value !== '');
                array_splice($ind2, 2, 0, ' ');
                $array[1] = $ind2;
                $array = array_filter($array, fn ($value) => !is_null($value) && $value !== '');
                $ind3 = array_filter($ind3, fn ($value) => !is_null($value) && $value !== '');
                $array[2] = $ind3;
                dump($array);
                print_r($array[2][1]);
                echo "<br>";
                // dump($line );
            });
        } catch (\Throwable $th) {
            dd($th);
        }


        // print_r($connection);
        // $connection = new \phpseclib\Net\SSH2($config['host']);

        // if (!$connection->login($config['username'], $config['password'])) {
        //     throw new Exception('Cannot connect to server');
        // }
        // print_r($config);




        // $contents = SSH::into('staging')->getString($remotePath);
    }

    public function connect()
    {
        $chunks = [];
        try {
            \SSH::into('new_connection2')->run("ip add print", function ($output) use (&$chunks) {
                $chunks[] = $output;
                // dump($line . PHP_EOL);

            });
        } catch (\Throwable $th) {
            dd($th);
        }

        $output = implode("", $chunks);

        $rows = explode("\n", $output);

        // menghapus baris pertama dan terakhir (judul tabel dan baris kosong terakhir)
        array_shift($rows);
        array_pop($rows);
        $data = [];
        foreach ($rows as $row) {

            $columns = preg_split('/\s+/', $row, -1, PREG_SPLIT_NO_EMPTY);
            if (count($columns) == 4) {
                array_splice($columns, 1, 0, "");
            }
            $data[] = $columns;
        }
        // dump($data);    
        // menampilkan tabel dengan komponen table pada Laravel
        echo '<table border=1>';
        echo '<tbody>';
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $column) {
                echo "<td>$column</td>";
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    public function list_connections()
    {
        $connections = config('remote.connections');
        dd($connections);
    }

    public function add_connection()
    {
     

        $newConfig = [
            'host' => 'new-host.com',
            'username' => 'new-username',
            'password' => 'new-password',
            'key'       => '',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 10,
        ];
        // config(['remote_extra.test' => $newConfig]);
        config(['remote.connections.testadas' => $newConfig]);
        
        $connections = config('remote_extra');
        dd($connections);
    }

    public function test_insert_data()
    {
        $remote = new Remote();

        $remote->name = 'test';
        $remote->host = 'example.com';
        $remote->username = 'ussername';
        $remote->password = Crypt::encryptString('123');
        $remote->key = '';
        $remote->keyphrase = '';
        $remote->agent = '';
        $remote->timeout = '';
        $remote->port = '22';
        $remote->save();
    }

    public function show_data()
    {
        $remote = Remote::all();
        try {
            $decrypted = Crypt::decryptString($remote[0]->password);
            dd($decrypted);
        } catch (DecryptException $e) {
            dd($e);
        }
    }
}
