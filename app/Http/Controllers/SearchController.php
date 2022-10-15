<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\SearchRequest;
use App\Models\Search;
use App\Models\SearchUser;
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
        $user = Auth::user();
        $attributes = $request->validated();

        // check if user has available free searches on account
        if ($attributes['active'] && $user->searchUsers()->active()->count() >= $user->limit) {
            return back()
                ->withErrors('You have no more free searches. Try disabling some older searches, or ask for new quota');
        }

        // check if search url exists, so we do only one scrape, even if multiple
        // users are asking for same search
        $search = Search::where('search_url', $attributes['search_url'])->first();
        if (!$search)
            $search = new Search();

        $search->fill($attributes)->save();

        $attributes['user_id'] = $user->id;
        $attributes['search_id'] = $search->id;

        $searchUser = new SearchUser();
        $searchUser->fill($attributes)->save();

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SearchUser $search
     * @return \Inertia\Response
     */
    public function edit(SearchUser $search): \Inertia\Response
    {
        $search->load('search');
        return Inertia::render('Search/Form', ['search' => $search]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SearchRequest $request
     * @param SearchUser $search
     * @return RedirectResponse
     */
    public function update(SearchRequest $request, SearchUser $search): RedirectResponse
    {
        $attributes = $request->validated();

        $user = Auth::user();
        // check if user has available free searches on account
        if ($attributes['active'] && $user->searchUsers()->active()->count() >= $user->limit) {
            return back()
                ->withErrors('You have no more free searches. Try disabling some older searches, or ask for new quota');
        }

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
