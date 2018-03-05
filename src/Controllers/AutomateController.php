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

    public function index()
    {
        return view('dist/index');
    }


    public function make()
    {
        $data = Input::all();
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
//        return $data;
        $modelName = trim($data['modelName']);
        $fillable = [];
        $columns = $data['columns'];
//        return $columns;
        $schema = [];
        $column_names = 'id';
        foreach ($columns as $column) {
            if ($column['columnName'] == 'id') {
//                array_push($schema, 'id');
            } else {
                $column_schema = $column['columnName'] . ':' . strtolower($column['dataType']);
                $column_names .= ',' . $column['columnName'];
                array_push($fillable, $column['columnName']);
                if ($column['nullStatus'] == 'nullable') {
                    $column_schema .= ':nullable';
                }
                if ($column['uniqueStatus'] == 'unique') {
                    $column_schema .= ':unique';
                }
                if ($column['defaultValue'] != 'none') {
                    $column_schema .= ":default('" . $column['defaultValue'] . "')";
                }
                array_push($schema, $column_schema);
            }
        }
        $fillable = implode(',', $fillable);
        $model_command = 'php artisan make-model ' . $modelName . ' --fillable=' . $fillable;
        $repo_command = 'php artisan make-repo ' . $modelName;
        $service_command = 'php artisan make-service ' . $modelName;
        $schema_command = 'php artisan make:migration:schema create_' .
            strtolower(str_plural($modelName)) . '_table' .
            ' --schema="' . implode(', ', $schema) . '" --model=0';
        $transformer_command = 'php artisan make-transformer ' . $modelName . ' ' . $column_names;
        $request_command = 'php artisan make-request ' . $modelName . ' ' . $column_names;
        $route_command = 'php artisan make-route ' . $modelName;
        $controller_command = 'php artisan make-controller ' . $modelName . ' ' . $column_names;
        try {
            $save = $this->saveToFile($modelName, [
                'Model' => $model_command,
                'Repository' => $repo_command,
                'Service' => $service_command,
                'Migration' => $schema_command,
                'Transformer' => $transformer_command,
                'Request' => $request_command,
                'Controller' => $controller_command,
                'Route' => $route_command,
                'status' => false
            ]);
            if ($save) {
                return '<h2> Successfully Created the sleleton. </h2>' .
                    '<h3>To generate all class run the following command</h3> <br>' .
                    '<code>php artisan igloo</code> <br><br>' .
                    '<h3>To get API route for this ' . $modelName . ' run the following command</h3> <br>' .
                    '<code>'.$route_command.'</code>';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return 'unknown error';
    }

    public function saveToFile($modelName, array $commands)
    {
        try {

            if (!File::exists(public_path('igloo.json'))) {
                File::put(public_path('igloo.json'), '{}');
            }
            $data = File::get(public_path('igloo.json'));
            $data = json_decode($data, true);

            $data[$modelName] = $commands;

            $status = File::put(public_path('igloo.json'), json_encode($data, JSON_PRETTY_PRINT));
            return true;
        } catch (\Exception $e) {
            throw $e;
            throw new \Exception('File Stream Problem.');
        }
    }


//    public function model()
//    {
//        $data = Input::all();
//
//        $rules = [
//            'model' => 'required',
//        ];
//        $validation = Validator::make($data, $rules);
//        if ($validation->fails())
//        {
//            return json_encode([
//                'status' => 400,
//                'error'  => $validation->errors()
//            ]);
//        }
//        $name = strtoupper($data['model'][0]).substr($data['model'], 1);
//        $fillable = isset($data['fillable'])?$data['fillable']:'';
//        $guarded = isset($data['guarded'])?$data['guarded']:'';
//        try
//        {
//            $status = Artisan::call('make-model', [
//                'name'          => $name,
//                '--fillable'   => $fillable,
//                '--guarded'    => $guarded
//            ]);
//        }
//        catch (\Exception $e)
//        {
//            return json_encode([
//                "status" => 400,
//                "data" => $e->getMessage()
//            ]);
//        }
//        return json_encode([
//            "status" => 200,
//            "data" => $status
//        ]);
//    }
}
