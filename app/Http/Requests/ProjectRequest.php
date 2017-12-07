<?php

namespace App\Http\Requests;

use App\Rules\CompanyDocument;
use App\Rules\TmpFileExists;
use App\Rules\TmpImageExists;
use App\Rules\ValidVideoUrl;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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

    public function messages()
    {
        return [
            'latitude.required' => 'Las coordenadas no pudieron ser leídas, vuelve a ingresar tu dirección. Si el problema persiste contacta al administrador',
            'longitude.required'  => 'Las coordenadas no pudieron ser leídas, vuelve a ingresar tu dirección. Si el problema persiste contacta al administrador',
            'latitude.numeric' => 'Las coordenadas no pudieron ser leídas, vuelve a ingresar tu dirección. Si el problema persiste contacta al administrador',
            'longitude.numeric'  => 'Las coordenadas no pudieron ser leídas, vuelve a ingresar tu dirección. Si el problema persiste contacta al administrador',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'holder' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'holder_links' => '',
            'holder_links.*' => 'required|url',
            // 'photo' => ['required', new TmpImageExists],
            'video' => new ValidVideoUrl,
            'latitude' => 'numeric|required',
            'longitude' => 'numeric|required',
            'address' => '',

            // 2.
            'description' => 'required',
            // 3.
            'opportunity' => 'required',
            // 4.
            'competition' => 'required',
            // // 5.
            'company_documents' => 'array',
            'company_documents.*' => new CompanyDocument,
            // // 6.
            'links' => '',
            'links.*' => 'required|url',
            // 7.
            'sectors' => 'required|array',
            // 8.
            'stage_id' => 'required',
            // 9.
            'business_model' => 'required',
            // // 10.
            'previous_capital' => 'required|integer',
            'total_sales' => 'required|integer',
            'round_size' => 'required|integer',
            'minimal_needed' => 'required|integer',
            'has_interested_investor' => 'required',
            'interested_investor_name' => '',
            'expected_sales_year_1' => 'required|integer',
            'expected_sales_year_2' => 'required|integer',
            'expected_sales_year_3' => 'required|integer',
            'rewards' => 'required|array',
            // 11.
            'team' => 'required|array',
            'team.*.name' => 'required',
            // 12.
            'kpis' => 'required|numeric',
            'kpis.*.time' => 'required',
            'kpis.*.description' => 'required',
            // 13.
            'key_documents' => 'array',
            'key_documents.*' => new CompanyDocument,
            // 14.
            'extra_documents' => 'array',
            'extra_documents.*' => new CompanyDocument,
        ];
    }
}
