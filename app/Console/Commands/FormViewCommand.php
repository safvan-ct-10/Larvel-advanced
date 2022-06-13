<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FormViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view_model {repo_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New View and Controller';

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
        $folder_name = lcfirst($name);
        if (!File::exists(resource_path('views/admin/'.$folder_name))) {
            File::makeDirectory(resource_path('views/admin/'.$folder_name));
        } else {
            $this->info("Folder exists!");
        }

        $controller_res = FormViewCommand::createControllerRequest($name);

        if ($controller_res) {
            FormViewCommand::createViews($name);
            FormViewCommand::updateRoutes($name);
            $this->info("Views Created! Happy Coding :)");
        } else {
            $this->info("Controller exists!");
        }
    }

    public static function createControllerRequest($name)
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

        $FOLDER_NAME = lcfirst($name);
        $parts = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY);

        $PERMISSION_NAME = implode("_", $parts);
        $PERMISSION_NAME = strtolower($PERMISSION_NAME);
        $ROUTE_NAME = implode(".", $parts);
        $ROUTE_NAME = strtolower($ROUTE_NAME);

        $controller_structure_file = file_get_contents(app_path()."/Console/Commands/ViewStructure/ViewController.txt");
        $controller_structure_file = str_replace('REPO_NAME', $name, $controller_structure_file);
        $controller_structure_file = str_replace('ROUTE_NAME', $ROUTE_NAME, $controller_structure_file);
        $controller_structure_file = str_replace('PERMISSION_NAME', $PERMISSION_NAME, $controller_structure_file);
        $controller_structure_file = str_replace('FOLDER_NAME', $FOLDER_NAME, $controller_structure_file);

        file_put_contents($controller_file, $controller_structure_file);



        $request_file = app_path('Http/Requests/Admin/'.$name.'Request.php'); // the file to change
        if (!file_exists($request_file)) {
            $request_structure_file = file_get_contents(app_path()."/Console/Commands/ViewStructure/ViewRequest.txt");
            $request_structure_file = str_replace('REPO_NAME', $name, $request_structure_file);
            file_put_contents($request_file, $request_structure_file);
        }

        return true;
    }
}
