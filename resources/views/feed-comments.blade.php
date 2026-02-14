{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ $siteName }} — Comments</title>
        <link>{{ url('/blog') }}</link>
        <description>Latest comments on {{ $siteName }}</description>
        <atom:link href="{{ route('feed.comments') }}" rel="self" type="application/rss+xml"/>
        @foreach($comments as $comment)
            <item>
                <title>{{ $comment->author_name }} on "{{ $comment->blogPost->title ?? 'Unknown' }}"</title>
                <link>{{ $comment->blogPost ? route('blog.show', $comment->blogPost->slug) . '#comment-' . $comment->id : url('/blog') }}</link>
                <description><![CDATA[{{ $comment->content }}]]></description>
                <pubDate>{{ $comment->created_at->toRssString() }}</pubDate>
                <guid>{{ url('/blog') }}#comment-{{ $comment->id }}</guid>
            </item>
        @endforeach
    </channel>
</rss>
