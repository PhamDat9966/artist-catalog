<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
{
    protected $table = 'album';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
        $condArtist     = "";
        $condStatus     = "";
        $condThumb      = "";

        switch ($task) {
            case 'add':
                $condThumb          = 'bail|required|mimes:jpeg,jpg,png,gif|max:10000';
                $condName           = "bail|required|between:5,100|unique:$this->table,name";
                $condStatus         = "bail|in:active,inactive";
                $condArtist         = "bail|required|exists:artist,id"; // kiểm tra id có tồn tại trong bản không
                break;
            case 'edit':
                $condThumb          = 'bail|mimes:jpeg,jpg,png,gif|max:10000';
                $condStatus         = "bail|in:active,inactive";
                $condName           = "bail|between:5,100|unique:$this->table,name,$id";
                $condArtist         = "bail|required|exists:artist,id"; // kiểm tra id có tồn tại trong bản không
                break;
        }

        return [
            'name'          => $condName,
            'artist_id'     => $condArtist,
            'thumb'         => $condThumb,
            'status'        => $condStatus,
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Tên album không được rỗng',
            'name.between'          => 'Tên album có độ dài từ 5 đển 100 ký tự',
            'name.unique'           => 'Tên album không được trùng với những bài viết sẵn có',
            'status.in'             => 'Status nên chọn active hoặc inactive',
            'thumb.required'        => 'Ảnh không được rỗng',
            'thumb.mimes'           => 'Hãy chọn ảnh có đuôi là : jpeg,jpg,png,gif',
            'thumb.max'             => 'Hãy chọn ảnh có độ lớn nhỏ hơn 10000kb',
            'artist_id.required'    => 'Hãy chọn 1 nghệ sĩ sở hữu album',
            'artist_id.exists'      => 'Hãy chọn một nghệ sĩ đã có trong danh sách',
        ];
    }
}
