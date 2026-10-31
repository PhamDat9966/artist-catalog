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
        return false;
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

        return [
            //
        ];
    }
}
