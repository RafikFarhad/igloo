<?php

namespace Farhad\Igloo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AutomateController extends Controller
{
    public function ping()
    {
        return json_encode([
            'data' => "Igloo is just fine.",
            "status" => 200
        ]);
    }

    public function make()
    {
        $data = Input::all();
//        return $data;
        $rules = [
            'modelName' => 'required',
            'columns' => 'required'
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return json_encode([
                'status' => 400,
                'error' => $validation->errors()
            ]);
        }
        $modelName = trim($data['modelName']);
        $table_name = null;
        if(isset($data['tableName']))
        {
            $table_name = trim($data['tableName']);
        }
        if (!$table_name) {
            $table_name = strtolower(str_plural($modelName));
        }
        $fillable = [];
        $columns = $data['columns'];
        $schema = [];
        $column_names = 'id';
        foreach ($columns as $column) {
            if ($column['columnName'] == 'id') {
                //ID Implemented automatically
            }
            else {
                $columnName = trim($column['columnName']);
                $dataType = trim($column['dataType']);
                $foreignTable = trim($column['foreignTable']);
                $nullStatus = trim($column['nullStatus']);
                $uniqueStatus = trim($column['uniqueStatus']);
                $defaultValue = trim($column['defaultValue']);

                $column_schema = $columnName . ':' . strtolower($dataType);
                $column_names .= ',' . $columnName;
                array_push($fillable, $columnName);
                if($foreignTable != null)
                {
                    $column_schema .= ':unsigned:foreign';
                }
                if ($nullStatus == 'nullable') {
                    $column_schema .= ':nullable';
                }
                if ($uniqueStatus == 'unique') {
                    $column_schema .= ':unique';
                }
                if ($defaultValue != 'none') {
                    if ($dataType == 'boolean' or $defaultValue == 'null') {
                        $column_schema .= ":default(" . $defaultValue . ")";
                    } else {
                        $column_schema .= ":default('" . $defaultValue . "')";
                    }
                }
                array_push($schema, $column_schema);
            }
        }
        $fillable = implode(',', $fillable);
        $model_command = 'php artisan make-model ' . $modelName . ' --guarded=id --table_name=' . $table_name;
        $repo_command = 'php artisan make-repo ' . $modelName;
        $service_command = 'php artisan make-service ' . $modelName . ' ' . $column_names;
        $schema_command = 'php artisan make:migration:schema create_' .
            $table_name . '_table' .
            ' --schema="' . implode(', ', $schema) . ',deleted_at:timestamp:nullable" --model=0';
        $transformer_command = 'php artisan make-transformer ' . $modelName . ' ' . $column_names;
        $request_command = 'php artisan make-request ' . $modelName . ' ' . $column_names;
        $request_command_update = 'php artisan make-request-update ' . $modelName . ' ' . $column_names;
        $route_command = 'php ../artisan make-route ' . $modelName;
        $route_list = $this->findRouteList($route_command);
        $route_command = 'php artisan make-route ' . $modelName;
        $controller_command = 'php artisan make-controller ' . $modelName;
        try {
            $save = $this->saveToFile($modelName, [
                'Model' => $model_command,
                'Repository' => $repo_command,
                'Service' => $service_command,
                'Migration' => $schema_command,
                'Transformer' => $transformer_command,
                'Request' => $request_command,
                'Request Update' => $request_command_update,
                'Controller' => $controller_command,
                'Route' => $route_command,
                'status' => false
            ]);
            if ($save) {
                return '<h2> Successfully Created the skeleton. </h2>' .
                    '<h3>To generate all class run the following command</h3> <br>' .
                    '<code>php artisan igloo</code> <br><br>' .
                    '<h3>API Routes for ' . $modelName . ' CRUD</h3> <br>' .
                    '<code>' . $route_list . '</code>';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return '<h2> There is something went wrong. </h2>';
    }

    public function findRouteList($cmd)
    {
        $route_list = [];
        try {
            exec($cmd, $route_list);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        $list = [];
        foreach ($route_list as $sentence) {
            if (trim($sentence) != '')
                array_push($list, $sentence);
        }
        $route_list = implode('<br>&nbsp;&nbsp;&nbsp;&nbsp;', $list);
        return $route_list;
    }

    public function saveToFile($modelName, array $commands)
    {
        try {
            if (!File::exists(public_path('igloo.json'))) {
                File::put(public_path('igloo.json'), '{}', 777);
            }
            $data = File::get(public_path('igloo.json'));
            $data = json_decode($data, true);
            $data[$modelName] = $commands;
            $status = File::put(public_path('igloo.json'), json_encode($data, JSON_PRETTY_PRINT));
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Something wen wrong regarding File Stream');
        }
    }

}
