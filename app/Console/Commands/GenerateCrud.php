<?php

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
     * path of folder
     */
    protected $path;
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
        self::formatPath($name,$package);
        $this->Resource($name,$package);
        $this->controllers($name, $package);
        $this->model($name, $package);
        $this->formRequest($name,$package);


        $this->getBr($name);
        $separator = '\\';
        $package = str_replace('/','\\',$package);

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

                Route::delete('delete/\{{$name}\}', [App\Http\Controllers\\$package\DeleteController::class, 'destroy'])
                    ->name('$name.delete')
                    ->middleware('permission:$name.delete');

                Route::put('\{{$name}\}', [App\Http\Controllers\\$package\UpdateController::class, 'updated'])
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
        $path = str_replace('/','\\',$package);

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
                    $path
                ],
                $this->getStub($controller.'Controller')
            );

            file_put_contents((app()->basePath() . "/app/Http/Controllers/{$package}/{$controller}Controller.php"), $controllerTemplate);
        }
    }

    protected function Resource($name,$package){

        $path = str_replace('/','\\',$package);

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
                $path
            ],
            $this->getStub('Resource')
        );

        mkdir((app()->basePath() . "/app/Http/Resources/".$package));

        file_put_contents((app()->basePath() . "/app/Http/Resources/{$package}/{$name}Resource.php"), $requestTemplate);
    }

    protected function formRequest($name, $package)
    {
        $path = str_replace('/','\\',$package);

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
                    $path
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
    }

    private function formatPath($name,$package){
        $path = str_replace('/','\\',$package);
        $path = str_replace($name,'',$path);
        $this->path = rtrim($path,'\\');
    }
}
