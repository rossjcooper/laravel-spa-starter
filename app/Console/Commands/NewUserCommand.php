<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class NewUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user to the system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->ask('Enter email address');
        $name = $this->ask('Enter user\'s name');
        $password = $this->secret('Enter password');

        $user = new User([
            'email' => $email,
            'name' => $name,
            'password' => Hash::make($password),
        ]);

        $user->save();

        $this->output->success('User added successfully');

        return 0;
    }
}
