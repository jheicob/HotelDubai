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

        $this->model($name, $package);
        $this->Resource($name,$package);
        $this->formRequest($name,$package);
        $this->controllers($name, $package);

        $this->getBr($name);

        $this->updateRouter($name,$package);
    }

    protected function updateRouter($name,$package){
        $separator = '\\';
        $name_controller = "\App\Http\Controllers\\" . $package . $separator . $name . "Controller::class";
        File::append(base_path('routes/api.php'),
            "
            Route::group(\n
            [\n
            'prefix'     => '{$name}',\n
            'middleware'  => 'auth'\n
            ], function () {\n
            \n
                Route::get('', [App\Http\Controllers\{$package}\IndexController::class, 'index'])\n
                    ->name('{$name}.index')\n
                    ->middleware('permission:{$name}.index');\n
            \n
                Route::post('create', [App\Http\Controllers\{$package}\CreateController::class, 'create'])\n
                    ->name('{$name}.create')\n
                    ->middleware('permission:{$name}.create');\n
            \n
                Route::delete('delete/{id}', [App\Http\Controllers\{$package}\DeleteController::class, 'destroy'])\n
                    ->name('{$name}.delete')\n
                    ->middleware('permission:{$name}.delete');\n
            \n
                Route::put('{id}', [App\Http\Controllers\{$package}\UpdatedController::class, 'updated'])\n
                    ->name('{$name}.updated')\n
                    ->middleware('permission:{$name}.updated');\n
            \n
                Route::get('get', [App\Http\Controllers\{$package}\IndexController::class, 'get'])\n
                    ->name('{$name}.get')\n
                    ->middleware('permission:{$name}.getPaginate');\n
            }\n
        );\n
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

        file_put_contents((app()->basePath() . "/app/Http/Resources/{$package}/{$name}Resource.php"), $requestTemplate);
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
