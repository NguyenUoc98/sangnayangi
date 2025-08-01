<?php

namespace App\Orchid\Screens\Food;

use App\Models\Food;
use App\Orchid\Layouts\Food\FoodEditLayout;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class FoodEditScreen extends Screen
{
    public $food;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Food $food): iterable
    {
        return [
            'food' => $food
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->food->exists ? 'Edit Food' : 'Create Food';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('trash')
                ->class('btn btn-link text-danger')
                ->confirm(__('Do you want to remove this?'))
                ->method('remove')
                ->canSee($this->food->exists),
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
            Layout::block(Layout::rows([
                Input::make('food.name')
                    ->required()
                    ->title('Name')
                    ->type('text')
                    ->placeholder(__('Name')),

                Input::make('food.price')
                    ->title('Price')
                    ->mask([
                        'alias'          => 'currency',
                        'prefix'         => '',
                        'groupSeparator' => ' ',
                        'digitsOptional' => true
                    ]),

                Input::make('food.address')
                    ->required()
                    ->title('Address')
                    ->type('text')
                    ->placeholder(__('Address')),

                Upload::make('food.image')
                    ->title('Image')
                    ->groups('food')
                    ->maxFiles(1)
                    ->value($this->food->attachment()->first()?->id)
                    ->media(),
            ]))
                ->title(__('Food Information'))
                ->description(__('Update food.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save')
                ),
        ];
    }

    /**
     * @param Food $food
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Food $food, Request $request)
    {
        $request->validate([
            'food.name'    => [
                'required',
            ],
            'food.price'   => [
                'required',
            ],
            'food.address' => [
                'required',
            ],
        ]);

        $food
            ->fill($request->collect('food')->except(['image', 'price'])->toArray())
            ->fill(['price' => str_replace(' ', '', $request->input('food.price'))])
            ->save();

        $food->attachment('food')->attach($request->input('food.image'));

        Toast::success(__('Food was saved.'));

        return redirect()->route('platform.systems.foods');
    }

    public function remove(Request $request){
        Food::findOrFail($request->get('id'))->delete();
        Toast::success(__('Food was removed'));
    }
}
