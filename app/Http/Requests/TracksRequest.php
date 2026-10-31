<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TracksRequest extends FormRequest
{
    protected $table = 'tracks';
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
        $condStatus     = "";
        $condAudio      = "";
        $condAlbum      = "";

        /*
            exists:album,id: id phải có thật trong bảng album. Giá trị 0 không có trong bảng nên tự bị loại,
            không cần notin:0. Cách này còn chặn được trường hợp gửi album_id = 999 (id không tồn tại),
            điều mà notin:0 không làm được.
        */

        switch ($task) {
            case 'add':
                $condAudio          = 'bail|required|file|mimes:mp3,mpga,wav,ogg|max:10000';
                $condName           = "bail|required|between:5,100|unique:$this->table,name";
                $condStatus         = "bail|in:active,inactive";
                $condAlbum          = "bail|required|exists:album,id"; // kiểm tra id có tồn tại trong bản không
                break;
            case 'edit':
                $condAudio          = 'bail|nullable|file|mimes:mp3,mpga,wav,ogg|max:10000';
                $condStatus         = "bail|in:active,inactive";
                $condName           = "bail|between:5,100|unique:$this->table,name,$id";
                $condAlbum          = "bail|required|exists:album,id";
                break;
        }

        return [
            'name'          => $condName,
            'status'        => $condStatus,
            'album_id'      => $condAlbum,
            'audio'         => $condAudio
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Tên track không được rỗng',
            'name.between'          => 'Tên track có độ dài từ 5 đển 100 ký tự',
            'name.unique'           => 'Tên track không được trùng với những bài viết sẵn có',
            'status.in'             => 'Status nên chọn active hoặc inactive',
            'audio.required'        => 'Audio không được rỗng',
            'audio.mimes'           => 'Hãy chọn audio có đuôi là : mp3,mpga,wav,ogg',
            'audio.max'             => 'Hãy chọn audio có độ lớn nhỏ hơn 10000kb',
            'album_id.required'     => 'Hãy chọn 1 album để chứa track',
            'album_id.exists'       => 'Album đã chọn không tồn tại',
        ];
    }
}
