# Igloo Code Generator


## Contents

- [Change Log](#changelog)
- [Installation](#installation)
- [Usage](#usage)
- [Super Usage](#super_usage)


## Change Log

### New in v1.2
- GUI support inside the package
- Drop Down API included
- Several Bug Fixed 

### New in v1.1
- Laravel 5.7 Support 
- Namespace Supports
- Several Bug Fixed 

## Installation

1) To install *Igloo Code Generator*, run the following command:

    ```shell
    composer require infancyit/igloo
    ```

2) Run the command below to load all configuration file: 

    ```shell
    php artisan vendor:publish --provider="InfancyIt\Igloo\IglooServiceProvider"
    ```

3) For allowing CORS on a API middleware group or route, add the `HandleCors` middleware to `middleware` array in the ```Kernel.php``` file:
   
   ```php
   protected $middleware = [
           ... ... ... ... ...
           ... ... ... ... ...
        
           \Barryvdh\Cors\HandleCors::class,
       ];
   ```

## Usage

### Create Model
Let's start by creating a basic Model:

Model will be saved on `app\Models` folder.

Run the following command on project root.

```shell
php artisan make-model Book
```

If you want to add `fillable` or `guarded` value you may pass the list of columns as well:

```shell
php artisan make-model Book --fillable=name,author,published_date
```
or
```shell
php artisan make-model Book --guarded=id
```
or

```shell
php artisan make-model Book --fillable=name,author,published_date --guarded=id
```

### Create Service
Let's create some basic **Service** which will extends our **BaseService** from `app\Services`:

Run the following command on project root.

```shell
php artisan make-service Book
```

### Create Repository
Let's create some basic **Repository** which will extends our **BaseRepository** from `app\Repositories`:

Run the following command on project root.

```shell
php artisan make-repository Book
```

### Create Transformer
Let's create a basic **Transformer**:

Transformer will be created in the `app/Transformers/Api` folder.

Run the following command on project root.

```shell
php artisan make-transformer Book id,name,author,published_date
```
In the creation of `Transformer` `attributes` list are required. All columns should be separated by a single `,` (comma). This will create the main portion like this
```
public function getTransformableFields($entity)
    {
        return [
            'id'                   => (int) $entity->id,
            'name'                 => $entity->name,
            'author'               => $entity->author,
            'published_date'       => $entity->published_date
        ];
    }
```
### Create Request
Let's create a basic **Request**:

Transformer will be created in the `app/Request/Api` folder.

Run the following command on project root.

```shell
php artisan make-request Book id,name,author,published_date
```
In the creation of `Request` `attributes` list are required. All columns should be separated by a single `,` (comma). This will create the main portion like this
```
public function rules()
    {
        return [
            'name'                   => 'required',
            'author'                 => 'required',
            'published_date'         => 'required'
        ];
    }
```
### Create Route
You can also create API routes for your model.
Run the following command on project root.

```shell
php artisan make-route Book
```
This command will output like this:
```
///////////////////////////// Book Routes //////////////////////////////
Route::group(['prefix' => 'book', 'namespace' => 'Api'], function () {
    Route::get('index', 'BookController@index')->name('book.index');
    Route::post('create', 'BookController@store')->name('book.store');
    Route::post('update', 'BookController@update')->name('book.update');
    Route::delete('delete', 'BookController@delete')->name('book.delete');
});

```
This command will not save anything. You've to copy this segment from console and paste it in your `web.php` or `api.php` file.
The assumption for the controller name will be [**Modelname**]Controller.



## Installation

- For bundle create visit

    [Igloo Wizard - http://wizard.cse.party](http://wizard.cse.party "Igloo Wizard")

- Or you can visit `\igloo` route after package installation.


## License

Igloo Code Generator is free software distributed under the terms of the MIT license.