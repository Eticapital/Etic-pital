<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function accept(Investment $investment)
    {
        $this->authorize('accept', $investment);
        return tap($investment->append(['can_reject', 'can_accept']))->accept();
    }

    public function reject(Investment $investment)
    {
        $this->authorize('reject', $investment);
        return tap($investment->append(['can_reject', 'can_accept']))->reject();
    }
}
