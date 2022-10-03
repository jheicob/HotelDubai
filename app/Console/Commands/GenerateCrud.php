<?php

/**
 * Created by PhpStorm.
 * User: zippyttech
 * Date: 06/08/18
 * Time: 03:11 PM
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:crud {name} {package?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generador de modelo con Repositorio, controller y servicio';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('name');
        $package = $this->argument('package') ?? $name;

        $this->controllers($name, $package);
        $this->model($name, $package);
        $this->formRequest($name,$package);
        $this->Resource($name,$package);


        $this->getBr($name);
        $separator = '\\';
        $name_controller = "\App\Http\Controllers\\" . $package . $separator . $name . "Controller::class";


        File::append(base_path('routes/api.php'),
            "
            Route::group(
            [
            'prefix'     => '$name',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\\$package\IndexController::class, 'index'])
                    ->name('$name.index')
                    ->middleware('permission:$name.index');

                Route::post('create', [App\Http\Controllers\\$package\CreateController::class, 'create'])
                    ->name('$name.create')
                    ->middleware('permission:$name.create');

                Route::delete('delete/{id}', [App\Http\Controllers\\$package\DeleteController::class, 'destroy'])
                    ->name('$name.delete')
                    ->middleware('permission:$name.delete');

                Route::put('{id}', [App\Http\Controllers\\$package\UpdateController::class, 'updated'])
                    ->name('$name.updated')
                    ->middleware('permission:$name.updated');

                Route::get('get', [App\Http\Controllers\\$package\IndexController::class, 'get'])
                    ->name('$name.get')
                    ->middleware('permission:$name.getPaginate');
            }
        );
        "
        );
    }

    protected function model($name, $package)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}', 'package'],
            [$name, $package],
            $this->getStub('Model')
        );

        file_put_contents((app()->basePath() . "/app/Models/{$name}.php"), $modelTemplate);
    }

    protected function controllers($name, $package)
    {
        $controllers = [
            'Index',
            'Update',
            'Create',
            'Delete'
        ];

            mkdir((app()->basePath() . "/app/Http/Controllers/{$package}"));
        foreach($controllers as $controller){

            $controllerTemplate = str_replace(
                [
                    '{{modelName}}',
                    '{{modelNamePluralLowerCase}}',
                    '{{modelNameSingularLowerCase}}',
                    '{{package}}'
                ],
                [
                    $name,
                    strtolower(Str::plural($name)),
                    strtolower($name),
                    $package
                ],
                $this->getStub($controller.'Controller')
            );

            file_put_contents((app()->basePath() . "/app/Http/Controllers/{$package}/{$controller}Controller.php"), $controllerTemplate);
        }
    }

    protected function Resource($name,$package){
        $requestTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{package}}'
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name),
                $package
            ],
            $this->getStub('Resource')
        );
        mkdir((app()->basePath() . "/app/Http/Resources/{$package}"));

        file_put_contents((app()->basePath() . "/app/Http/Resources/{$package}/{$name}Resources.php"), $requestTemplate);
    }

    protected function formRequest($name, $package)
    {
        $files = [
            'Create',
            'Update',
        ];
        mkdir((app()->basePath() . "/app/Http/Requests/{$package}"));

        foreach($files as $file){

            $requestTemplate = str_replace(
                [
                    '{{modelName}}',
                    '{{modelNamePluralLowerCase}}',
                    '{{modelNameSingularLowerCase}}',
                    '{{package}}'
                ],
                [
                    $name,
                    strtolower(Str::plural($name)),
                    strtolower($name),
                    $package
                ],
                $this->getStub($file.'Request')
            );

            file_put_contents((app()->basePath() . "/app/Http/Requests/{$package}/{$file}Request.php"), $requestTemplate);
        }
    }


    protected function getStub($type)
    {
        // echo resource_path("Generator/stubs/$type.stub");
        return file_get_contents(resource_path("Generator/stubs/$type.stub"));
    }

    protected function getBr($name)
    {
        File::append(base_path('routes/api.php'), " \n");
        File::append(base_path('routes/api.php'), "/** routes para ${name} **/ \n");
        File::append(base_path('routes/api.php'), " \n");
    }
}
