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

class ScrapeSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $search;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Search $search)
    {
        $this->search = $search;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws GuzzleException
     */
    public function handle(SearchService $searchService)
    {
        $searchService->handleScheduledSearch($this->search);
    }
}
