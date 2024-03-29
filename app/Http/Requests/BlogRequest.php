<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BlogRequest extends FormRequest
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
            'title'       => 'required|max:30',
            'body'        => 'required|max:2000',
            'errorlog'    => 'max:2000',
            'classification'=> 'required',
            'file'        => 'max:2000'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'=>'제목을 입력하세요.',
            'title.max' => '제목은 30자를 초과할 수 없습니다.',
            'errorlog.max' => '오류메시지는 2000자를 초과할 수 없습니다.',
            'body.max'=>'내용은 2000자를 초과할 수 없습니다.',
            'body.required'  => '내용을 입력하세요.',
        ];
    }

}
