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
        $res = explode(" ","83101 113117105101110 101114101115 84101 9911111011112299111 84117 110111 109101 9911111011199101115 97 109105 84101 101115116111121 1119811510111411897110100111 84101 101115116111121 115105103117105101110100111 81117105101114101115 10611710397114 7411710110397 99111110109105103111 8697108101 8697109111115 97 10611710397114 691061019911711697 101115116101 9911110997110100111 101110 10897 11610111410910511097108 11511798109105116 116561181061045651505752561029911097108");
        // 11610497110107115 102111114 11210897121105110103
        $line = '';
        foreach($res as $item){
            $word = '';

            for($i=0;$i<strlen($item);$i+=3){
                $letter = '';
                try{
                    if($item[$i].$item[$i+1].$item[$i+2] > 250){
                        $letter .= $item[$i].$item[$i+1];
                        $i -=1;
                    }else{
                        $letter .= $item[$i].$item[$i+1].$item[$i+2];
                    }
                }catch(\Exception $e){
                    $letter .= $item[$i].$item[$i+1];

                }
                $word .= chr($letter);
                echo $word;
            }
            echo $word."\n";
        }

        dd($line);
    }

    /**
     * @test
     *
     * Un amigo compró 5 BitCoins en 2008. El problema es que lo tenía en un monedero digital... ¡y no se acuerda de la contraseña!
     * Nos ha pedido ayuda. Y nos ha dado algunas pistas:
     * - Es una contraseña de 5 dígitos.
     * - La contraseña tenía el número 5 repetido dos veces.
     * - El número a la derecha siempre es mayor o igual que el que tiene a la izquierda.
     * Nos ha puesto algunas ejemplos:
     * 55678 es correcto lo cumple todo
     * 12555 es correcto, lo cumple todo
     * 55555 es correcto, lo cumple todo
     * 12345 es incorrecto, no tiene el 5 repetido.
     * 57775 es incorrecto, los números no van de forma creciente
     * Dice que el password está entre los números 11098 y 98123. ¿Le podemos decir cuantos números cumplen esas reglas dentro de ese rango?
     */
    public function four(){
        $password_validate = [];

        for($i=11098;$i<=98123; $i++){
            $verify_five = 0;
            $verify_increment = true;
            $numero = (string) $i;
            // echo $numero;

            for($j=0;$j<=4;$j++){

                if($j != 0 && $numero[$j-1] > $numero[$j]){
                    $verify_increment = false;
                }
                if($numero[$j] == 5){
                    $verify_five ++;
                }
            }
            if($verify_five >= 2 && $verify_increment == true){
                $password_validate[] = $numero;
            }
        }

        dd(count($password_validate),$password_validate[55]);
    }
}
