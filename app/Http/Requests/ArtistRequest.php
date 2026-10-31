<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ArtistRequest extends FormRequest
{
    protected $table = "artist";
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool  // Ủy quyền, phải return true mới được validate, mục đích ngằm ngăn chặn ip của một cá nhân hay khu vực là hacker
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $task = 'add';
        // dd($this->toArray());

        if(isset($this->id)) $task = 'edit';

        $id         = $this->id;
        $condName       = "";
        $condStatus     = "";
        $condThumb      = "";

        switch ($task) {
            case 'add':
                $condThumb          = 'bail|required|mimes:jpeg,jpg,png,gif|max:10000';
                $condName           = "bail|required|between:5,100|unique:$this->table,name";
                $condStatus         = "bail|in:active,inactive";
                break;
            case 'edit':
                $condThumb          = 'bail|mimes:jpeg,jpg,png,gif|max:10000';
                $condStatus         = "bail|in:active,inactive";
                $condName           = "bail|between:5,100|unique:$this->table,name,$id";
                break;
        }

        return [
            'name'          => $condName,
            'status'        => $condStatus,
            'thumb'         => $condThumb,
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Tên bài viết không được rỗng',
            'name.between'          => 'Tên bài viết có độ dài từ 5 đển 100 ký tự',
            'name.unique'           => 'Tên bài viết không được trùng với những bài viết sẵn có',
            'status.in'             => 'Status nên chọn active hoặc inactive',
            'thumb.required'        => 'Ảnh không được rỗng',
            'thumb.mimes'           => 'Hãy chọn ảnh có đuôi là : jpeg,jpg,png,gif',
            'thumb.max'             => 'Hãy chọn ảnh có độ lớn nhỏ hơn 10000kb',
        ];
    }
}
