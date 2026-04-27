<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\BlogCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class CourseList extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'category')]
    public $selectedCategory = null;

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage(); // Important pour ne pas rester bloqué sur une page inexistante
    }

    public function render()
    {
        // On récupère les catégories qui ont au moins une formation
        $categories = BlogCategory::has('courses')->get();

        $courses = Course::with(['videoCategory', 'media'])
            ->where('is_published', true)
            ->when($this->selectedCategory, fn ($query) => $query->where('blog_category_id', $this->selectedCategory))
            ->when($this->search, fn ($query) =>
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('summary', 'like', '%' . $this->search . '%')
            )
            ->latest('published_at')
            ->paginate(6);

        return view('livewire.course-list', [
            'courses' => $courses,
            'categories' => $categories
        ]);
    }
}