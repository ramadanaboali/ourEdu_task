<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * @property mixed limit
 * @property mixed offset
 * @property mixed field
 * @property mixed sort
 */
class PaginateRequest extends FormRequest
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
        return [
            "columns"=>'sometimes|array',
            "operand"=>'sometimes|array',
            "column_values"=>'sometimes|array',
            'limit' => 'sometimes|integer|min:1',
            'offset'=> 'sometimes|integer|min:0',
            'sort' => 'sometimes|in:ASC,DESC,asc,desc',
            'resource' => 'sometimes|in:all,custom',
            'field' => 'sometimes|string',
            "deleted"=>'sometimes|in:true,false',
            "paginate"=>'sometimes|in:true,false',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(responseFail('Validation Error',400,$errors));
    }
}
