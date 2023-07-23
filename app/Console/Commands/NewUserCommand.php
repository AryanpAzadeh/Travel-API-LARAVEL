<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class NewUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a New User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user['name'] = $this->ask('Name of the new user');
        $user['email'] = $this->ask('email of the new user');
        $user['password'] = $this->secret('password of the new user');
        $roleName = $this->choice('role of the new user' , ['admin' , 'editor'] , default: 1);
        $role = Role::where('name' , $roleName)->first();
        if (!$role)
        {
            $this->error('role not found !');
            return -1;
        }
        $validator = Validator::make($user, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Password::defaults()],
        ]);
        if ($validator->fails()){
            foreach ($validator->errors()->all() as $error){
                $this->error($error);
            }
            return -1;
        }

        \DB::transaction(function () use ($role , $user){
            $user['password'] = Hash::make($user['password']);
            $newUser = User::create($user);
            $newUser->roles()->attach($role->id);
        });

        $this->info('user create successfully');
        return 0;


    }
}
