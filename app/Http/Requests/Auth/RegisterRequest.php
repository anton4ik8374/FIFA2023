<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'phone' => ['required', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed',
                'regex:/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^?&*()`]{8,}/'],
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'Поле Имя не может быть пустым!',
            'name.max' => 'Максимальная длина Имени 255 символов',

            'last_name.required' => 'Поле Фамилия не может быть пустым!',
            'last_name.max' => 'Максимальная длина Фамилии 255 символов',

            'phone.required' => 'Поле телефон не может быть пустым!',
            'phone.max' => 'Максимальная длина Телефона 255 символов',
            'phone.unique' => 'Такой номер телефона уже используется',

            'email.required'=>'Поле email обязательно для заполнения',
            'email.email'=>'Поле email должно соответствовать e-mail адресу пример example@mail.com',
            'email.max'=>'Максимальная длина email 255 символов',
            'email.unique'=>'Такой email уже используется',

            'password.required'=>'Поле пароль не может быть пустым',
            'password.min'=>'Минимальная длина Пароля 8 символов',
            'password.confirmed'=>'Поля пароль и проверочный пароль должны совпадать',
            'password.regex'=>'Вы ввели слишком простой пароль Минимальная длина 8 символов , должны быть использованы буквы латинского алфавита верхнего и нижнего регистра а также спецсимволы @$!%*#?& и цифры от 0 - 9'
        ];
    }



    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
