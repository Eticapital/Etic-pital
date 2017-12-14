<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $this->authorize('index', Investment::class);

        $query = request()->input('query')
            ? Investment::search(request()->input('query'))
            : Investment::latest();

        $results = $query->paginate(request()->input('per_page', 10));

        if (request()->input('appends')) {
            return tap($results)->each(function ($project) {
                $project->lazyAppend(request()->input('appends'));
            });
        }

        return $results;
    }

    public function accept(Investment $investment)
    {
        $this->authorize('accept', $investment);
        return tap($investment->append(['can_reject', 'can_accept', 'can_delete']))->accept();
    }

    public function reject(Investment $investment)
    {
        $this->authorize('reject', $investment);
        return tap($investment->append(['can_reject', 'can_accept', 'can_delete']))->reject();
    }

    public function destroy(Investment $investment)
    {
        $this->authorize('delete', $investment);
        return tap($investment)->delete();
    }
}
