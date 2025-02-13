<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')){
            return $this->store();
        }else{
            return $this->update();
        }
    }
    public function store(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:8|max:255'
        ];
    }

    public function update(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:8|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres',
            'email.required'=> 'O campo email é obrigatório',
            'email.email'=> 'O campo email deve ser um email válido',
            'email.unique'=> 'O email informado já está em uso',
            'password.required'=> 'O campo senha é obrigatório',
            'password.min'=> 'O campo senha deve ter no mínimo 8 caracteres',
            'password.max'=> 'O campo senha deve ter no máximo 255 caracteres'
        ];
    }
}
