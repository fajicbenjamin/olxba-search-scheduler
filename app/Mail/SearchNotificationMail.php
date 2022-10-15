<?php

namespace App\Mail;

use App\Models\Search;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SearchNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $newArticles;
    protected $search;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $newArticles, Search $search, User $user)
    {
        $this->newArticles = $newArticles;
        $this->search = $search;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.search-notification-mail')
            ->with(['newArticles' => $this->newArticles, 'user' => $this->user])
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Novi artikli za pretragu ' . $this->search->name);
    }
}
