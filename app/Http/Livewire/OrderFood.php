<?php

namespace App\Http\Livewire;

use App\Models\Food;
use Livewire\Component;

class OrderFood extends Component
{
    public $foodLists = [];
    public $order;

    public function mount($order)
    {
        $this->order     = $order;
        if ($order) {
            $this->foodLists = $order->foods()->get(['id'])->map(function ($value) {
                return $value->id;
            })->toArray();
        }
    }

    public function render()
    {
        $foods        = Food::with('attachment')->get();
        $foodSelected = $foods->filter(function ($food) {
            return in_array($food->id, $this->foodLists);
        });
        return view('livewire.order-food', [
            'foods'        => $foods,
            'foodSelected' => $foodSelected,
            'order'        => $this->order
        ]);
    }
}
