@component('mail::message')
# Zdravo {{ $user->name }},

Zakazana pretraga je pronašla nove artikle


@foreach($newArticles as $article)

<a href="'https://olx.ba/artikal/{!!$article['id']!!}">
    <img src="{!!$article['image_url']!!}" alt="{!!$article['title']!!}">
    <span>{!! $article['title'] !!}</span>
</a>
<br>

@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
