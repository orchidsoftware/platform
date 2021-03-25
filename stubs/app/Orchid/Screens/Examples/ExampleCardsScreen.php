<?php

namespace App\Orchid\Screens\Examples;

use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Contracts\Cardable;
use Orchid\Screen\Layouts\Card;
use Orchid\Screen\Layouts\Facepile;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ExampleCardsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Cards';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'user' => User::firstOrFail(),
            'card' => new class implements Cardable {
                /**
                 * @return string
                 */
                public function title(): string
                {
                    return 'Title of a longer featured blog post';
                }

                /**
                 * @return string
                 */
                public function description(): string
                {
                    return 'This is a wider card with supporting text below as a natural lead-in to additional content.
                            This content is a little bit longer. Mauris a orci congue, placerat lorem ac, aliquet est.
                            Etiam bibendum, urna et hendrerit molestie, risus est tincidunt lorem, eu suscipit tellus
                            odio vitae nulla. Sed a cursus ipsum. Maecenas quis finibus libero. Phasellus a nibh rutrum,
                            molestie orci sit amet, euismod ex. Donec finibus sodales magna, quis fermentum augue
                            pretium ac.';
                }

                /**
                 * @return string
                 */
                public function image(): ?string
                {
                    return 'https://picsum.photos/600/300';
                }

                /**
                 * @return \Orchid\Support\Color|string
                 */
                public function color(): ?Color
                {
                    return Color::INFO();
                }

                /**
                 * @return \Orchid\Support\Color|string
                 */
                public function status(): ?Color
                {
                    return Color::INFO();
                }
            },
            'cardPersona'    => new class implements Cardable {
                /**
                 * @return string
                 */
                public function title(): string
                {
                    return 'Prepare for presentation';
                }

                /**
                 * @return string
                 */
                public function description(): string
                {
                    return
                        '<p>This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>'.
                        new Facepile(User::limit(4)->get()->map->presenter());
                }

                /**
                 * @return string
                 */
                public function image(): ?string
                {
                    return null;
                }

                /**
                 * @return mixed
                 */
                public function color(): ?Color
                {
                    return Color::DANGER();
                }

                /**
                 * {@inheritdoc}
                 */
                public function status(): ?Color
                {
                    return Color::INFO();
                }
            },
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::columns([
                [
                    new Card('cardPersona'),
                    new Card('cardPersona', [
                        Button::make('Example Button')
                            ->method('showToast')
                            ->icon('bag'),

                        Button::make('Example Button')
                            ->method('showToast')
                            ->icon('bag'),
                    ]),
                ],
                new Card('card', [
                    Button::make('Example Button')
                        ->method('showToast')
                        ->icon('bag'),
                    Button::make('Example Button')
                        ->method('showToast')
                        ->icon('bag'),
                ]),
            ]),

            Layout::legend('user', [
                Sight::make('id'),
                Sight::make('name'),
                Sight::make('email'),
                Sight::make('email_verified_at', 'Email Verified')->render(function (User $user) {
                    return $user->email_verified_at === null
                        ? '<i class="text-danger">●</i> False'
                        : '<i class="text-success">●</i> True';
                }),
                Sight::make('created_at', 'Created'),
                Sight::make('updated_at', 'Updated'),
                Sight::make('Simple Text')->render(function () {
                    return 'This is a wider card with supporting text below as a natural lead-in to additional content.
    This content is a little bit longer. Mauris a orci congue, placerat lorem ac, aliquet est.
    Etiam bibendum, urna et hendrerit molestie, risus est tincidunt lorem, eu suscipit tellus
            odio vitae nulla. Sed a cursus ipsum. Maecenas quis finibus libero. Phasellus a nibh rutrum,
            molestie orci sit amet, euismod ex. Donec finibus sodales magna, quis fermentum augue
            pretium ac.';
                }),
            ])->title('User'),
        ];
    }

    /**
     * @param Request $request
     */
    public function showToast(Request $request): void
    {
        Toast::warning($request->get('toast', 'Hello, world! This is a toast message.'));
    }
}
