<?php

namespace App\Livewire;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'category')]
    public $selectedCategory = null;

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
    }

    public function render()
    {
        $categories = BlogCategory::has('blogPosts')->get();

        $posts = BlogPost::with(['blogCategory', 'media'])
            ->published()
            ->where('published_at', '<=', now())
            ->when($this->selectedCategory, fn ($query) => $query->where('blog_category_id', $this->selectedCategory))
            ->when($this->search, fn ($query) =>
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%')
            )
            ->latest('published_at')
            ->paginate(6);

        return view('livewire.post-list', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }
}
