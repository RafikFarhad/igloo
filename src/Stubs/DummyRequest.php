<?php
/**
 * Created by Igloo Generator.
 * Date: DUMMYDATE
 */

namespace DummyNamespace;

use App\Http\Requests\FormRequest;

class DummyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [/*DummyColumnValues*/
        ];
    }

    /**
     * Validate the given class instance.
     *
     * @return void
     */
    public function validateResolved()
    {
        // TODO: Implement validateResolved() method.
    }
}
