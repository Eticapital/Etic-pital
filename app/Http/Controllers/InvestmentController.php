<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $this->authorize('index', Investment::class);

        $query = request()->input('query')
            ? Investment::search(request()->input('query'))
            : Investment::sortByRequest(request())->latest('investments.created_at');

        if (($status_filter = request()->input('status')) !== null) {
            $query->where('investment_status', $status_filter);
        }

        if ($project_id = request()->input('project')) {
            $query->where('project_id', $project_id);
        }

        if ($user_id = request()->input('user')) {
            $query->where('owner_id', $user_id);
        }

        if ($from = request()->input('from')) {
            $query->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
        }

        if ($to = request()->input('to')) {
            $query->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
        }

        $results = $query->paginate(request()->input('per_page', 10));

        if (request()->input('appends')) {
            return tap($results)->each(function ($investment) {
                $investment->lazyAppend(request()->input('appends'));
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

    public function show(Investment $investment)
    {
        $this->authorize('view', $investment);
        return $investment;
    }

    public function update(Investment $investment, Request $request)
    {
        $data = $this->validate($request, [
            'project_id' => 'required',
            'owner_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'residence' => '',
            'organization' => 'required',
            'amount' => 'required|numeric',
        ]);

        return tap($investment)->update($data);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'project_id' => 'required',
            'owner_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'residence' => '',
            'organization' => 'required',
            'amount' => 'required|numeric',
        ]);

        return Investment::create($data);
    }
}
