<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Platform;

use Orchid\Tests\TestUnitCase;
use Orchid\Platform\Models\User;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Orchid\Screen\Layouts\Rows;



class ScreenTest extends TestUnitCase
{
    /**
     * @test
     */
/*
    public function it_has_the_correct_instance()
    {
        $user = factory(User::class)->create();

        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }*/
    
    public function it_has_the_make_screen()
    {
        $user = factory(User::class)->create();

        $userScreen = new UserScreen();
        $userScreen->handle($user->id);
        
        //$this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $userScreen->query($user->id)['user']);
        $this->assertNotNull($user);
        $this->assertEquals($userScreen->query($user->id)['user']->id, $user->id);
    }
}




class UserScreen extends Screen
{
    public function query(int $id = null): array
    {
        $user = is_null($id) ? new User : User::findOrFail($id);
        //dd($user );
        return [
            'user'       => $user,
        ];
    }
    public function commandBar(): array
    {   
        return [
            Link::name('Save')
                ->icon('icon-check')
                ->method('save'),
        ];
    }
    public function layout(): array
    {   
        return [
            UserLayout::class,
        ];
    }
    public function save($id)
    {
        return true;
    }
}

class UserLayout extends Rows
{   
    public function fields(): array
    {
        //dd($this);
        return User::getFieldsEdit()->all();
    }
}
