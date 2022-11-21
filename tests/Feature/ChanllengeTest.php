<?php

namespace Tests\Feature;

use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChanllengeTest extends TestCase
{
    /**
     * @test
     */
    public function first_chanllenge(){
        $res = Http::get('https://codember.dev/users.txt');

        $res = explode("\n", $res->body());
        $new = [];
        $line = '';
        foreach($res as $item){
            if($item != ''){
                $line .= $item .' ';
            }else{
                $new[] = trim($line);
                $line = '';

            }
        }

        $users = [];

        $keys = [
            'usr:',// nombre de usuario
            'eme:',// email
            'psw:',// contraseña
            'age:',// edad
            'loc:',// ubicación
            'fll:',// número de seguidores
        ];
        dump(count($new));

        $i = 0;
        foreach($new as $user){
            $bool = true;
            foreach($keys as $key){
                if(strpos($user, $key) === false){
                    $bool = false;

                }
            }
            if($bool){
                $users[$i] = $user;
                $i++;
            }
        }
        $cant = count($users);
        dump($cant);
        dump($users[$cant-1]);
    }

    /**
     * @test
     */
    public function second_chanllenge(){
        $res = Http::get('https://codember.dev/encrypted.txt');

        $res = explode(" ", $res->body());
        // 11610497110107115 102111114 11210897121105110103
        $line = '';
        foreach($res as $item){
            $word = '';

            for($i=0;$i<strlen($item);$i+=3){
                $letter = '';
                if($item[$i].$item[$i+1].$item[$i+2] > 900){
                    $letter .= $item[$i].$item[$i+1];
                    $i -=1;
                }else{
                    $letter .= $item[$i].$item[$i+1].$item[$i+2];
                }
                $word .= chr($letter);
            }
            echo $word."\n";
        }

        dd($line);
    }
}
