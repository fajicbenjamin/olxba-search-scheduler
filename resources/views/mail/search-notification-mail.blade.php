<style>
    .mail-flex {
        display: flex;
        flex-direction: row;
    }

    .mail-flex span {
        display: flex;
        align-items: center;
    }

    .mail-flex span p {
        margin: 0 10px;
    }

    @media (max-width: 768px) {
        .mail-flex {
            flex-direction: column;
        }

        .mail-flex span {
            align-items: start;
        }
    }
</style>

@component('mail::message')
# Zdravo {{ $user->name }},

Spašena pretraga je pronašla nove artikle.

@foreach($newArticles as $article)

<div class="mail-flex">
    <img src="{!!$article['image_url']!!}" alt="{!!$article['title']!!}">
    <span>

[{!! $article['title'] !!}]({{'https://olx.ba/artikal/' . $article['id'] }})
    </span>
</div>
<br>
@endforeach

Pozdrav,<br>
{{ config('app.name') }}
@endcomponent
