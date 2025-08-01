<?php

namespace App\Http\Livewire;

use App\Events\StartSpinner;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ChooseBuyer extends Component
{
    public $order;
    public $userTodays;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->order      = Order::with(['details'])
            ->whereDate('date', Carbon::now())
            ->orderByDesc('updated_at')
            ->first();
        $this->userTodays = $this->order->details->map(function ($value) {
            return [
                'id'   => $value->user->id,
                'text' => $value->user->name
            ];
        })->toArray();
    }

    protected $listeners = [
        'submit-buyer'  => 'submit',
        'start-spinner' => 'startSpinner',
    ];

    public function submit(int $userId)
    {
        $this->order->buyer_id = $userId;
        $this->order->save();
        $users = $this->order->details()->where('user_id', '<>', auth()->id())->get()->map(function ($detail) {
            return $detail->user;
        });
        Notification::sendNow($users, new \App\Notifications\ChooseBuyer($userId));
    }

    public function startSpinner()
    {
        broadcast(new StartSpinner($this->id))->toOthers();
    }

    public function render()
    {
        $colors = [
            '#eae56f',
            '#89f26e',
            '#7de6ef',
            '#e7706f'
        ];
        foreach ($this->userTodays as $key => $value) {
            $this->userTodays[$key]['fillStyle'] = $colors[$key % 4];
        }

        return view('livewire.choose-buyer', [
            'userTodays' => $this->userTodays,
        ]);
    }
}
