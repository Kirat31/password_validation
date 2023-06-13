<?php

namespace App\Console\Commands;

use App\Models\Users;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordHistories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password_history:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the password history for existing users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = Users::all();

        foreach ($users as $user) {
            $previousPasswords = json_decode($user->password_history, true) ?? [];

            // Add the current password to the password histories
            $previousPasswords[] = sha1($user->password);

            // Update the password_histories column
            $user->password_history = json_encode($previousPasswords);
            $user->save();
        }

        $this->info('Password histories updated successfully.');
       
        //return 0;
    }
}
