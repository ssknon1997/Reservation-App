<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'user';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'shop_id'     => ['required', 'exists:shop,id'],
            'reserved_at' => ['required', 'date','after:now'],
            'note'        => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'shop_id.required'     => '店舗を選択してください',
            'shop_id.exists'       => '選択された店舗は存在しません',
            'reserved_at.required' => '予約日時は必須です',
            'reserved_at.date'     => '正しい日時形式で入力してください',
            'reserved_at.after'    => '予約日時は現在より後の日時を指定してください',
            'note.max'             => 'メモは500字以内で入力してください',
        ];
    }
}
