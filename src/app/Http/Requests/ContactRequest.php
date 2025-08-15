<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ContactRequest extends FormRequest
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
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:1,2,3'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'tel1' => ['required',  'regex:/^\d{1,5}$/'],
            'tel2' => ['required',  'regex:/^\d{1,5}$/'],
            'tel3' => ['required',  'regex:/^\d{1,5}$/'],
            'address' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'detail' => ['required', 'string', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'last_name.required' => '姓を入力してください',
            'first_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問合せ内容は120文字以内で入力してください',
        ];
    }

    // 電話番号の3つのフィールドをまとめてバリデーションエラーを追加
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $tel1 = $this->input('tel1');
            $tel2 = $this->input('tel2');
            $tel3 = $this->input('tel3');

            // すべて空の場合
            if (!$tel1 && !$tel2 && !$tel3) {
                $validator->errors()->add('tel', '電話番号を入力してください');
                return;
            }

            // 形式が正しくない場合
            if (
                ($tel1 && !preg_match('/^\d{1,5}$/', $tel1)) ||
                ($tel2 && !preg_match('/^\d{1,5}$/', $tel2)) ||
                ($tel3 && !preg_match('/^\d{1,5}$/', $tel3))
            ) {
                $validator->errors()->add('tel', '電話番号は5桁までの数字で入力してください。');
            }
        });
    }
}
