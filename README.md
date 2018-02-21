# Igloo Code Generator


## Contents

- [Installation](#installation)
- [Usage](#usage)

## Installation

1) In order to install Igloo Code Generator, just add run the following command::

```json
composer require farhad/igloo
```
*If your laravel version is >=5.5 you don't need to apply step (2).*

2) Open your `config/app.php` and add the following to the `providers` array:

```shell
Farhad\Igloo\IglooServiceProvider::class
```

3) Run the command below to publish the package file: 

```shell
php artisan vendor:publish --provider="Farhad\Igloo\IglooServiceProvider"
php artisan vendor:publish --provider="Barryvdh\Cors\ServiceProvider"

```

4) For allowing CORS on a API middleware group or route, add the `HandleCors` middleware to your group in the ```Kernel.php``` file:
   
   ```php
   protected $middlewareGroups = [
       'web' => [
          // ...
       ],
   
       'api' => [
           // ...
           \Barryvdh\Cors\HandleCors::class,
       ],
   ];
   ```

## Usage


### Create Model
Let's start by creating a basic Model:

Model will be saved on `app\Model` folder.

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
/////////////////////////////// Book Routes //////////////////////////////////

Route::get('book/', 'BookController@index')->name('Book.index');
Route::get('book/add', 'BookController@add')->name('Book.add');
Route::post('book/store', 'BookController@store')->name('Book.add.store');
Route::get('book/edit/{id}', 'BookController@edit')->name('Book.edit');
Route::post('book/store/{id}', 'BookController@edit_store')->name('Book.edit.store');
Route::post('book/delete/{id}', 'BookController@delete')->name('Book.delete');

```
This command will not save anything. You've to copy this segment from console and paste it in your `web.php` or `api.php` file.
The assumption for the controller name will be **Modelname**Controller.

## License

Igloo Code Generator is free software distributed under the terms of the MIT license.