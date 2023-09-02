<?php
// 改修中20230809
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'user_name' => 'required',
            'password' => 'required',
        ];
    }
}

// 改修予定：

//     public function rules()
//     {
//         return [
//             'user_name' => [
//                 'required',
//                 'max:20',
//                 Rule::unique('users', 'user_name')->where(function ($query) {
//                     $query->where('password', $this->input('password'));
//                 }),
//             ],
//             'password' => 'required|max:15',
//         ];
//     }

//     public function messages()
//     {
//         return [
//             'user_name.unique' => '同じパスワードで別のユーザー名を選択してください。',
//         ];
//     }
// }
