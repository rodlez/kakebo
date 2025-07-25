<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Livewire\Component;

class CategoriesCreate extends Component
{
    public $inputs;
    public $show = 0;

    protected $rules = [
        'inputs.*.name' => 'required|min:3|unique:categories,name|distinct'
    ];

    protected $messages = [
        'inputs.*.name.required' => 'The field is required',
        'inputs.*.name.min' => 'The field must have at least 3 characters',
        'inputs.*.name.unique' => 'The category with this name is already created',
        'inputs.*.name.distinct' => 'This field has a duplicate, name must be unique'
    ];

    public function mount()
    {
        $this->fill([
            'inputs' => collect([['name' => '']])
        ]);
    }

    public function help()
    {
        $this->show++;
    }

    public function remove($key)
    {
        $this->inputs->pull($key);
    }

    public function add()
    {
        $this->inputs->push(['name' => '']);
    }

    public function save()
    {
        $this->validate();

        foreach ($this->inputs as $input) {

            try {
                Category::create(['name' => $input['name']]);
            } catch (QueryException $exception) {

                $errorInfo = $exception->errorInfo;
                // Return the response to the client..
                return to_route('categories.index')->with('message', 'Error(' . $errorInfo[0] . ') creating the category (' . $input['name'] . ')');
            }
        }

        $message = "";
        $this->inputs->count() === 1 ? $message = 'Category ' . $input['name'] . ' created' : $message = $this->inputs->count() . ' new categories created';

        return to_route('categories.index')->with('message', $message);
    }

    public function render()
    {
        return view('livewire.categories-create');
    }
}
