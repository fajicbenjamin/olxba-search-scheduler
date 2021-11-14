<?php

namespace App\Services;

use App\Mail\SearchNotificationMail;
use App\Models\Search;
use App\Models\SearchArticle;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;

class SearchService
{
    protected $client;

    private const PAGE_STEP = 30;
    private const PAGE_SUFFIX = '&vrstapregleda=tabela&sort_order=desc&stranica=';
    private const ARTICLE_SELECTOR = 'div.obicniArtikal';
    private const ARTICLE_TITLE_SELECTOR = 'p.na';
    private const IMAGE_SELECTOR = 'div.slika img';

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     */
    public function handleScheduledSearch(Search $search)
    {
        $searchUrl = $search->search_url;

        $previousArticles = $search->searchArticles->pluck('article_id');
        $articles = $this->getArticles($searchUrl);

        $newArticles = $articles->whereIn('id', $articles->pluck('id')->diff($previousArticles));

        $toRemove = $search->searchArticles()
            ->whereIn('article_id', $previousArticles->diff($articles->pluck('id')));
        SearchArticle::destroy($toRemove->pluck('id')->toArray());


        // prepare to save new ones
        $searchId = $search->id;
        $data = [];
        $newArticles->each(function ($article) use (&$data, $searchId) {
            array_push($data, [
                'article_id' => $article['id'],
                'name' => $article['title'],
                'image_url' => $article['image_url'],
                'search_id' => $searchId
            ]) ;
        });

        $search->searchArticles()->createMany($data);

        if (count($data) > 0) {
            // send email for new ones
            Mail::to($search->user->email)
                ->send(new SearchNotificationMail($newArticles->toArray(), $search));
        }
    }

    /**
     * @throws GuzzleException
     */
    private function getArticles(string $searchUrl): Collection
    {

        $promises = [];
        $result = collect();

        $firstPage = $this->client->get($searchUrl);
        $content = $firstPage->getBody()->getContents();
        $crawler = new Crawler($content);

        $searchCount = $this->getSearchCount($crawler);
        $numberOfPages = (int) ceil($searchCount / self::PAGE_STEP);

        // get articles for first page response
        $result = $result->concat($this->crawlArticles($crawler));

        // get other pages
        for ($i = 2; $i <= $numberOfPages; $i++) {
            // add requests to promises array and then execute them concurrently
            $promises = array_merge($promises, [
                $i => $this->client->getAsync($searchUrl . self::PAGE_SUFFIX . $i)
            ]);
        }

        $responses = Promise\Utils::settle($promises)->wait();

        // traverse response bodies and crawl articles
        collect($responses)->each(function ($response) use (&$result) {
            $content = $response['value']->getBody()->getContents();
            $result = $result->concat($this->crawlArticles(new Crawler($content)));
        });

        return $result;
    }

    private function crawlArticles(Crawler $crawler): Collection
    {
        $ids = $crawler->filter(self::ARTICLE_SELECTOR)->extract(['id']);
        $titles = $crawler->filter(self::ARTICLE_TITLE_SELECTOR)->extract(['_text']);
        $images = $crawler->filter(self::IMAGE_SELECTOR)->extract(['src']);

        $articles = collect();

        for ($i = 0; $i < count($titles); $i++) {

            if ($ids[$i] !== '' && $ids[$i] !== 'loader_ucitavanje') {
                $articles->add([
                    'id' => (int) substr($ids[$i], strlen('art_')),
                    'title' => $titles[$i],
                    'image_url' => $images[$i]
                ]);
            }

        }

        return $articles;
    }

    private function getSearchCount(Crawler $crawler): int
    {
        $countDiv = $crawler->filter('div.brojrezultata')->text();

        return (int) filter_var($countDiv, FILTER_SANITIZE_NUMBER_INT);
    }
}
