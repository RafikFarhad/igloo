<?php
/**
 * Created by PhpStorm.
 * User: vivacom
 * Date: 6/2/17
 * Time: 2:26 PM
 */

namespace App\Http\Requests;

use App\Responses\SimpleResponse;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

abstract class FormRequest extends LaravelFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();
    public function response(array $errors)
    {
        if($this->expectsJson()){
            $transformed = [];

            foreach ($errors as $field => $message) {
                $transformed[] = [
                    'field' => $field,
                    'message' => $message[0]
                ];
            }
            return response()->json($errors->errorBag, 422);
        }
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);

    }
}
