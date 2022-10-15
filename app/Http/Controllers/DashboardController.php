<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $searches = Auth::user()->searchUsers()
            ->with('search')
            ->get();

        return Inertia::render('Dashboard', ['searches' => $searches]);
    }
}
