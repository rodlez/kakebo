<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{

    use WithPagination;

    //protected $paginationTheme = "bootstrap";
    public $orderColumn = "categories.id";
    public $sortOrder = "desc";
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';
    public $search = "";
    public $perPage = 25;

    public $selections = [];

    public function updated()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = "";
    }

    public function bulkClear()
    {
        $this->selections = [];
    }

    public function bulkDelete()
    {
        foreach ($this->selections as $selection) {
            $category = Category::find($selection);
            $category->delete();
        }

        return to_route('categories.index')/* ->with('message', 'categories successfully deleted.') */;
    }

     public function sorting($columnName = "")
    {
        $caretOrder = "up";
        if ($this->sortOrder == 'asc') {
            $this->sortOrder = 'desc';
            $caretOrder = 'down';
        } else {
            $this->sortOrder = 'asc';
            $caretOrder = 'up';
        }

        $this->sortLink = '<i class="fa-solid fa-caret-' . $caretOrder . '"></i>';
        $this->orderColumn = $columnName;
    }


    public function render()
    {
        $found = 0;
        $categories = Category::orderby($this->orderColumn, $this->sortOrder)->select('*');

        if (!empty($this->search)) {
            $found = $categories->where('name', "like", "%" . $this->search . "%")->count();
        }

        $total = $categories->count();

        $categories = $categories->paginate($this->perPage);

        return view('livewire.categories', [
            'categories'    => $categories,
            'found'         => $found,
            'column'        => $this->orderColumn,
            'total'         => $total,
        ]);
    }
}
