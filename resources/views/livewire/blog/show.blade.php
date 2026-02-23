@push('meta')
    <meta name="description" content="{{ $metaDescription }}" />

    <!-- Open Graph -->
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $metaTitle }}" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:url" content="{{ route('blog.show', $post->slug) }}" />
    @if ($metaImage)
        <meta property="og:image" content="{{ $metaImage }}" />
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ $metaImage ? 'summary_large_image' : 'summary' }}" />
    <meta name="twitter:title" content="{{ $metaTitle }}" />
    <meta name="twitter:description" content="{{ $metaDescription }}" />
    @if ($metaImage)
        <meta name="twitter:image" content="{{ $metaImage }}" />
    @endif
@endpush

<article class="mx-auto max-w-3xl">
    <!-- Header -->
    <header class="mb-8">
        @if ($post->featuredImageUrl())
            <img
                src="{{ $post->featuredImageUrl() }}"
                alt="{{ $post->title }}"
                class="mb-6 w-full rounded-lg object-cover"
                style="max-height: 400px"
            />
        @endif

        <h1
            class="text-3xl font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong sm:text-4xl"
        >
            {{ $post->title }}
        </h1>

        <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-on-surface dark:text-on-surface-dark">
            <!-- Author -->
            <div class="flex items-center gap-2">
                <x-avatar :src="$post->user->avatarUrl()" :initials="$post->user->initials()" size="sm" />
                <span>{{ $post->user->name }}</span>
            </div>

            <span>&middot;</span>

            <!-- Date -->
            <time datetime="{{ $post->published_at->toISOString() }}">
                {{ $post->published_at->format('M d, Y') }}
            </time>
        </div>

        <!-- Tags -->
        @if ($post->tags->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($post->tags as $tag)
                    <x-badge size="sm" variant="info">{{ $tag->name }}</x-badge>
                @endforeach
            </div>
        @endif

        <!-- Categories -->
        @if ($post->categories->isNotEmpty())
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($post->categories as $category)
                    <x-badge size="sm" variant="default">{{ $category->name }}</x-badge>
                @endforeach
            </div>
        @endif
    </header>

    <x-separator />

    <!-- Content -->
    <div class="prose dark:prose-invert mt-8 max-w-none text-on-surface-strong dark:text-on-surface-dark-strong">
        {!! $post->body !!}
    </div>
</article>
