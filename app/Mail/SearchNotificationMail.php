<?php

namespace App\Mail;

use App\Models\Search;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SearchNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $newArticles;
    protected $search;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $newArticles, Search $search)
    {
        $this->newArticles = $newArticles;
        $this->search = $search;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.search-notification-mail')
            ->with(['newArticles' => $this->newArticles, 'user' => $this->search->user])
            ->from('benjo@benjo.com', 'Benjo Inc')
            ->subject('Novi artikli za pretragu ' . $this->search->name);
    }
}
