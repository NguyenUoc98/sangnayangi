<?php

namespace App\Orchid\Screens\Food;

use App\Models\Food;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class FoodListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'foods' => Food::with('attachment')
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Foods list';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.systems.foods.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('foods', [
                TD::make('image', 'Image')
                    ->alignCenter()
                    ->render(function (Food $food) {
                        return '<img src="' . asset($food->attachment()->first()?->url()) . '" width="150px">';
                    }),
                TD::make('name', 'Name')
                    ->filter(Input::make()),
                TD::make('price', 'Price (VNĐ)')
                    ->alignCenter()
                    ->render(function (Food $food) {
                        return number_format($food->price, 0);
                    }),
                TD::make('address', 'Address'),
                TD::make('created_at', __('Created at'))
                    ->sort()
                    ->render(function (Food $food) {
                        return $food->created_at->toDateTimeString();
                    }),
                TD::make('updated_at', __('Updated at'))
                    ->sort()
                    ->render(function (Food $food) {
                        return $food->updated_at->toDateTimeString();
                    }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (Food $food) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Edit'))
                                    ->route('platform.systems.foods.edit', $food->id)
                                    ->icon('pencil'),

                                Button::make(__('Delete'))
                                    ->icon('trash')
                                    ->class('btn btn-link text-danger')
                                    ->confirm(__('Do you want to remove this?'))
                                    ->method('remove', [
                                        'id' => $food->id,
                                    ]),
                            ]);
                    }),
            ]),
        ];
    }

    public function remove(Request $request){
        Food::findOrFail($request->get('id'))->delete();
        Toast::success(__('Food was removed'));
    }
}
