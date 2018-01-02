<?php

namespace App\Http\Controllers;

use App\Mail\FondoDeInversionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FondoDeInversionController extends Controller
{
    public function submitForm(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'acreditado' => '',
            'portafolio' => '',
            'investment' => 'required|numeric',
            'sectors' => 'required|array',
            'level' => '',
            'comments' => '',
        ]);

        Mail::to('alfonso@vexilo.com')
            ->send(new FondoDeInversionMail($data));

        return $data;
    }
}
