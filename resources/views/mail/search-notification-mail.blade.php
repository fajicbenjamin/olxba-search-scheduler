@component('mail::message')
# Zdravo {{ $user->name }},

Zakazana pretraga je pronašla nove artikle koji su objavljeni u odnosu na prošli put


@foreach($newArticles as $article)

<a href="'https://olx.ba/artikal/{!!$article['id']!!}">
    <div style="height: 75px;">
        <img src="{!!$article['image_url']!!}" alt="{!!$article['title']!!}">
        <span style="display: inline-block; line-height: 75px; vertical-align: bottom">{!! $article['title'] !!}</span>
    </div>
</a>
<br>

@endforeach

Pozdrav,<br>
{{ config('app.name') }}
@endcomponent
