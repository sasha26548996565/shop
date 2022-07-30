@component('mail::message')
Api Token changed: {{ $apiToken }}

@component('mail::button', ['url' => route('index')])
    Перейти на сайт
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
