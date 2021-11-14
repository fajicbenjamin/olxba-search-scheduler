<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\SearchRequest;
use App\Models\Search;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SearchController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Search/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SearchRequest $request
     * @return RedirectResponse
     */
    public function store(SearchRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $attributes['user_id'] = Auth::id();
        $attributes['active'] = true; // todo change

        $search = new Search();
        $search->fill($attributes)->save();

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Search $search
     * @return \Inertia\Response
     */
    public function edit(Search $search): \Inertia\Response
    {
        return Inertia::render('Search/Form', ['search' => $search]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SearchRequest $request
     * @param Search $search
     * @return RedirectResponse
     */
    public function update(SearchRequest $request, Search $search): RedirectResponse
    {
        $attributes = $request->validated();
        $search->fill($attributes)->save();

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Search $search
     * @return void
     */
    public function destroy(Search $search)
    {
        $search->delete();
    }
}
