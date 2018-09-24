<?php

use Illuminate\Database\Seeder;
use App\Item;
use App\User;
use App\Role;
use App\Category;
use App\Topic;

class DatabaseSeeder extends Seeder
{   
    protected $items;

    protected $users;

    protected $roles;

    protected $seeds = [
        'migration',
        'items',
        'users',
        'roles',
        'category',
        'topics'
    ];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->seeds as $seed)
        {
            call_user_func([$this, $seed]);
        }
    }

    public function migration()
    {
        $this->command->call('migrate:fresh');
        $this->command->line('Migrated tables');
    }

    public function items()
    {
        $this->items = factory(Item::class, 20)->create();
        $this->command->line('Seeded Items');
    }

    public function users()
    {
        $this->users = factory(User::class, 2)->create();
        $this->users[0]->email = 'admin@admin.com';
        $this->users[1]->email = 'test@test.com';
        $this->users[0]->save();
        $this->users[1]->save();

        $this->command->line('Seeded Users');
    }

    public function roles()
    {
        $role = [
            'admin',
            'customer'
        ];

        $id = 1;
        for($i=0; $i<=1; $i++){
            factory(Role::class)->create(['user_id'=>$id, 'role'=>$role[$i]]);
            $id++;
        }

        $this->command->line('Seeded Roles');
    }

    public function category()
    {
        factory(Category::class, 5)->create();

        $this->command->line('Seeded Category');
    }

    public function topics()
    {
        $data = ['title'=>'Sample'];

        factory(Topic::class)->create($data);

        $this->command->line('Seeded Topic');
    }




}
