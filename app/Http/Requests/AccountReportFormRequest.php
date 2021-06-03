<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\rulesaid;

class AccountReportFormRequest extends FormRequest
{
    use rulesaid{
        rules as public trait_rules;
    }

    const field_names = [
        'client_acc_id'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //從 config/validators 建立驗證
        return $this->trait_rules(self::field_names);
    }
}
