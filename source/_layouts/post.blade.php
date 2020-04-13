@extends('_layouts.master')

@push('meta')
<meta property="og:title" content="{{ $page->title }}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ $page->getUrl() }}" />
<meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('body')
@if ($page->cover_image)
@include('_components.img', ['alt' => $page->title . 'cover image', 'src' => $page->cover_image ])
@endif

<h1 class="leading-none mb-2">{{ $page->title }}</h1>

<p class="text-primary-shade font-thin text-xl md:mt-0">{{ $page->author }} • {{ date('F j, Y', $page->date) }}</p>

@if ($page->categories)
@foreach ($page->categories as $i => $category)
<a href="{{ '/blog/' . $page->language . '/categories/' . $category }}" title="View posts in {{ $category }}"
    class="inline-block bg-secondary-complement hover:bg-secondary leading-loose tracking-wide text-secondary-shade hover:text-secondary-complement uppercase text-xs font-semibold rounded mr-2 px-3 pt-px">{{ $category }}</a>
@endforeach
@endif

<div class="border-b border-secondary text-base" v-pre>
    @yield('content')
</div>

<div class="border-b border-secondary mb-10 pb-4 pt-4 text-base">
    <details class="">
        <summary class="font-semibold">Webmentions</summary>
        <div class="flex flex-col">
            @if (empty($page->webmentions($page)))
            <p>{{ $page->translate("page.no_comments") }}</p>
            @endif
            @foreach ($page->webmentions($page) as $i => $comment)
            <div class="comment">
                <div class="comment-author">
                    {{ $comment->author->name }}
                </div>
                <div class="comment-content">
                    {{ $comment->content->html }}
                    <a href="' . $comment['url'] . '">Link</a>
                </div>
            </div>
            @endforeach
        </div>
    </details>
</div>

<nav class="flex justify-between text-sm md:text-base">
    <div>
        @if ($next = $page->getNext())
        <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
            &LeftArrow; {{ $next->getShortTitle() }}
        </a>
        @endif
    </div>

    <div>
        @if ($previous = $page->getPrevious())
        <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
            {{ $previous->getShortTitle() }} &RightArrow;
        </a>
        @endif
    </div>
</nav>
@endsection
