<?php

namespace App\Jobs;

use App\Models\Search;
use App\Services\SearchService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduledSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     * @throws GuzzleException
     */
    public function handle(SearchService $searchService)
    {
        $searches = Search::with('user')->get();

        $searches->each(function ($search) use ($searchService) {
            $searchService->handleScheduledSearch($search);
        });
    }
}
