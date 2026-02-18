<?php

declare(strict_types=1);

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.blog')]
final class Show extends Component
{
    public Post $post;

    public string $metaTitle = '';

    public string $metaDescription = '';

    public ?string $metaImage = null;

    public function mount(string $slug): void
    {
        $this->post = Post::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with(['user', 'tags', 'media'])
            ->firstOrFail();

        $this->metaTitle = $this->post->meta_title ?: $this->post->title;
        $this->metaDescription = $this->post->meta_description ?: $this->post->getExcerpt();
        $this->metaImage = $this->post->featuredImageUrl();
    }

    public function render()
    {
        return view('livewire.blog.show');
    }
}
