<?php

namespace Farhad\Igloo\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Farhad\Igloo\GeneratorClass;

class IglooCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igloo
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Model, Repo, Service, Migration, Request, Request, Transformer, Route & Controller';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try
        {
            if(File::exists(public_path('igloo.json')))
            {
                $data = File::get(public_path('igloo.json'));
                $message = [];
                $models = json_decode($data, true);
                foreach ($models as $model => $commands)
                {
                    $short_message = [];
                    if($commands['status'] == true)
                    {
                        $short_message['Status'] = 'Modules Already Exist';
                    }
                    else
                    {
                        foreach ($commands as $key => $cmd)
                        {
                            if($key=='status')
                            {
                                $cmd = true;
                                continue;
                            }
                            try
                            {
                                $status = exec($cmd);
                            }
                            catch (\Exception $e)
                            {
                                $status = $e.getMessage();
                            }
                            $short_message[$key] = $status;
                        }
                    }
                    $message[$model] = $short_message;
                }
                /// Change status false to true /////////////////////////////////////////////////////////////
                foreach ($models as $model => $commands)
                {
                    $models[$model]['status'] = true;
                }
                File::put(public_path('igloo.json'), json_encode($models, JSON_PRETTY_PRINT));
                /////////////////////////////////////////////////////////////////////////////////////////////
                /// php artisan migrate /////////////////////////////////////////////////////////////////////
                try
                {
                    $status = exec('php artisan migrate');
                }
                catch (\Exception $e)
                {
                    $status = $e.getMessage();
                }
                $message['migrate'] = $status;
                /////////////////////////////////////////////////////////////////////////////////////////////
                $this->info(json_encode($message, JSON_PRETTY_PRINT));
            }
            else
            {
                throw new \Exception('igloo.json not exist.');
            }
        }
        catch (\Exception $e)
        {
            $this->error('Error is: '.$e->getMessage());
        }
    }


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


}
