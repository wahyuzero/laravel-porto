{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ $siteName }} Blog</title>
        <link>{{ url('/blog') }}</link>
        <description>{{ $siteName }} developer blog</description>
        <language>en</language>
        <atom:link href="{{ url('/feed') }}" rel="self" type="application/rss+xml"/>
        @foreach($posts as $post)
        <item>
            <title>{{ $post->title }}</title>
            <link>{{ url('/blog/' . $post->slug) }}</link>
            <guid>{{ url('/blog/' . $post->slug) }}</guid>
            <pubDate>{{ $post->published_at->toRfc2822String() }}</pubDate>
            <description>{{ $post->excerpt ?? Str::limit($post->content_md, 200) }}</description>
        </item>
        @endforeach
    </channel>
</rss>
