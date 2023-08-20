<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'content' => 'required',
        ];
    }
}
