<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {repo_name} {type}'; // page or modal

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New View and Controller - Specify type page or modal';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!File::exists(resource_path('views'))) {
            File::makeDirectory(resource_path('views'));
        }
        if (!File::exists(resource_path('views/admin'))) {
            File::makeDirectory(resource_path('views/admin'));
        }

        $name = $this->argument('repo_name');
        $type = $this->argument('type');
        $folder_name = lcfirst($name);
        if (!File::exists(resource_path('views/admin/'.$folder_name))) {
            File::makeDirectory(resource_path('views/admin/'.$folder_name));
        } else {
            $this->info("Folder exists!");
        }

        $model_res = self::createModel($name);
        $model_res = self::createMigration($name);

        if ($model_res) {
            $controller_res = self::createControllerRequest($name, $type);

            if ($controller_res) {
                self::createViews($name, $type);
                self::updateRoutes($name, $type);
                $this->info($name." - Views, Controller, Model and Migration Created! Happy Coding :)");
            } else {
                $this->info("Controller exists!");
            }
        } else {
            $this->info("Model exists!");
        }
    }

    public static function createModel($name)
    {
        if (!File::exists(app_path('Models'))) {
            File::makeDirectory(app_path('Models'));
        }

        $model_file = app_path('Models/'.$name.'.php'); // the file to change
        if (file_exists($model_file)) {
            return false;
        }

        $model_structure_file = file_get_contents(app_path()."/Console/Commands/View/ViewModel.txt");
        $model_structure_file = str_replace('REPO_NAME', $name, $model_structure_file);
        $model_structure_file = str_replace('TABLE_NAME', strtolower($name), $model_structure_file);

        file_put_contents($model_file, $model_structure_file);
        return true;
    }

    public static function createMigration($name)
    {
        if (!File::exists(base_path('database'))) {
            File::makeDirectory(base_path('database'));
        }

        if (!File::exists(base_path('database/migrations'))) {
            File::makeDirectory(base_path('database/migrations'));
        }

        $title = date('Y_m_d').'_create_'.strtolower($name).'s_table.php';

        $migration_file = base_path('database/migrations/'.$title); // the file to change
        if (file_exists($migration_file)) {
            return false;
        }

        $migration_structure_file = file_get_contents(app_path()."/Console/Commands/View/ViewMigration.txt");
        $migration_structure_file = str_replace('TABLE_NAME', strtolower($name), $migration_structure_file);

        file_put_contents($migration_file, $migration_structure_file);
        return true;
    }

    public static function createControllerRequest($name, $type)
    {
        if (!File::exists(app_path('Http'))) {
            File::makeDirectory(app_path('Http'));
        }

        if (!File::exists(app_path('Http/Controllers'))) {
            File::makeDirectory(app_path('Http/Controllers'));
        }

        if (!File::exists(app_path('Http/Requests'))) {
            File::makeDirectory(app_path('Http/Requests'));
        }

        if (!File::exists(app_path('Http/Requests/Admin'))) {
            File::makeDirectory(app_path('Http/Requests/Admin'));
        }

        if (!File::exists(app_path('Http/Controllers/Admin'))) {
            File::makeDirectory(app_path('Http/Controllers/Admin'));
        }

        $controller_file = app_path('Http/Controllers/Admin/'.$name.'Controller.php'); // the file to change
        if (file_exists($controller_file)) {
            return false;
        }

        $parts = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY);
        $PERMISSION_NAME = strtolower(implode("_", $parts));
        $ROUTE_NAME = strtolower(implode(".", $parts));

        if($type == 'page') {
            $controller_structure_file = file_get_contents(app_path()."/Console/Commands/View/page/ViewController.txt");
        }
        elseif($type == 'modal') {
            $controller_structure_file = file_get_contents(app_path()."/Console/Commands/View/modal/ViewController.txt");
        }

        $controller_structure_file = str_replace('REPO_NAME', $name, $controller_structure_file);
        $controller_structure_file = str_replace('ROUTE_NAME', $ROUTE_NAME, $controller_structure_file);
        $controller_structure_file = str_replace('PERMISSION_NAME', $PERMISSION_NAME, $controller_structure_file);
        $controller_structure_file = str_replace('FOLDER_NAME', lcfirst($name), $controller_structure_file);

        file_put_contents($controller_file, $controller_structure_file);


        $request_file = app_path('Http/Requests/Admin/'.$name.'Request.php'); // the file to change
        if (!file_exists($request_file)) {
            if($type == 'page') {
                $request_structure_file = file_get_contents(app_path()."/Console/Commands/View/page/ViewRequest.txt");
            }
            elseif($type == 'modal') {
                $request_structure_file = file_get_contents(app_path()."/Console/Commands/View/modal/ViewRequest.txt");
            }
            $request_structure_file = str_replace('REPO_NAME', $name, $request_structure_file);
            file_put_contents($request_file, $request_structure_file);
        }

        return true;
    }

    public static function createViews($name, $type)
    {
        $index_file = resource_path('views/admin/'.lcfirst($name).'/index.blade.php');

        $parts = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY);
        $TITLE_NAME = implode(" ", $parts);
        $PERMISSION_NAME = implode("_", $parts);
        $PERMISSION_NAME = strtolower($PERMISSION_NAME);
        $ROUTE_NAME = implode(".", $parts);
        $ROUTE_NAME = strtolower($ROUTE_NAME);

        if($type == 'page') {
            $index_structure_file = file_get_contents(app_path()."/Console/Commands/View/page/index.txt");
        }
        elseif($type == 'modal') {
            $index_structure_file = file_get_contents(app_path()."/Console/Commands/View/modal/index.txt");
        }
        $index_structure_file = str_replace('TITLE_NAME', $TITLE_NAME, $index_structure_file);
        $index_structure_file = str_replace('ROUTE_NAME', $ROUTE_NAME, $index_structure_file);
        file_put_contents($index_file, $index_structure_file);

        $create_file = resource_path('views/admin/'.lcfirst($name).'/create-update.blade.php');
        if($type == 'page') {
            $create_structure_file = file_get_contents(app_path()."/Console/Commands/View/page/createUpdate.txt");
        }
        elseif($type == 'modal') {
            $create_structure_file = file_get_contents(app_path()."/Console/Commands/View/modal/createUpdate.txt");
        }
        $create_structure_file = str_replace('TITLE_NAME', $TITLE_NAME, $create_structure_file);
        $create_structure_file = str_replace('ROUTE_NAME', $ROUTE_NAME, $create_structure_file);
        file_put_contents($create_file, $create_structure_file);

        return true;
    }

    public static function updateRoutes($name)
    {
        $parts = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY);

        $TITLE_NAME = implode(" ", $parts);
        $PERMISSION_NAME = implode("_", $parts);
        $PERMISSION_NAME = strtolower($PERMISSION_NAME);
        $ROUTE_NAME = implode(".", $parts);
        $ROUTE_NAME = strtolower($ROUTE_NAME);
        $ROUTE_GET_NAME = implode("-", $parts);
        $ROUTE_GET_NAME = strtolower($ROUTE_GET_NAME);

        $routes_file = base_path("routes/web.php"); // the file to change
        $routes_structure_file = file_get_contents($routes_file);
        $route_txt="
    // TITLE_NAME
    Route::get('ROUTE_GET_NAME', [
        'as' => 'ROUTE_NAME.index',
        'uses' => 'REPO_NAMEController@index',
        //'middleware' => ['checkPrivilege:PERMISSION_NAME'],
    ]);
    Route::get('ROUTE_GET_NAME/list', [
        'as' => 'ROUTE_NAME.list',
        'uses' => 'REPO_NAMEController@result',
        //'middleware' => ['checkPrivilege:PERMISSION_NAME'],
    ]);
    Route::get('ROUTE_GET_NAME/create-update/{id?}', [
        'as' => 'ROUTE_NAME.create.update',
        'uses' => 'REPO_NAMEController@createUpdate',
        //'middleware' => ['checkPrivilege:PERMISSION_NAME'],
    ]);
    Route::post('ROUTE_GET_NAME/create-update', [
        'as' => 'ROUTE_NAME.create.update.post',
        'uses' => 'REPO_NAMEController@createUpdatePost',
        //'middleware' => ['checkPrivilege:PERMISSION_NAME'],
    ]);
    Route::get('ROUTE_GET_NAME/action/{id}/{status}', [
        'as' => 'ROUTE_NAME.action',
        'uses' => 'REPO_NAMEController@action',
        //'middleware' => ['checkPrivilege:PERMISSION_NAME'],
    ]);

    //ViewStructureDontRemoveThisLine";

        $route_txt = str_replace('REPO_NAME', $name, $route_txt);
        $route_txt = str_replace('TITLE_NAME', $TITLE_NAME, $route_txt);
        $route_txt = str_replace('ROUTE_GET_NAME', $ROUTE_GET_NAME, $route_txt);
        $route_txt = str_replace('ROUTE_NAME', $ROUTE_NAME, $route_txt);
        $route_txt = str_replace('PERMISSION_NAME', $PERMISSION_NAME, $route_txt);
        $routes_structure_file = str_replace('//ViewStructureDontRemoveThisLine', $route_txt, $routes_structure_file);
        $res = file_put_contents($routes_file, $routes_structure_file);

        return true;
    }
}
