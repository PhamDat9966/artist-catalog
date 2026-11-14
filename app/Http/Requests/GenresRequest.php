<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GenresRequest extends FormRequest
{
    protected $table = "genres";
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
                $condName           = "bail|required|between:2,100|unique:$this->table,name";
                $condStatus         = "bail|in:active,inactive";
                break;
            case 'edit':
                $condStatus         = "bail|in:active,inactive";
                $condName           = "bail|between:2,100|unique:$this->table,name,$id";
                break;
        }

        return [
            'name'          => $condName,
            'status'        => $condStatus,
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Tên thể loại âm nhạc không được rỗng',
            'name.between'          => 'Tên thể loại âm nhạc có độ dài từ 5 đển 100 ký tự',
            'name.unique'           => 'Tên thể loại âm nhạc không được trùng với những thể loại âm nhạc sẵn có',
            'status.in'             => 'Status nên chọn active hoặc inactive',
        ];
    }
}
