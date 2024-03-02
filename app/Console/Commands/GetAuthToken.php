<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GetAuthToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-auth-token {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Для использования CRUD категорий нужен пользователь с role admin. Введите его id для получения токена.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user_id = (int)$this->argument('user_id');

        $user = User::find($user_id);

        if (is_null($user)) {

            $this->info('Bearer NULL');

            return Command::FAILURE;
        }

        $token = $user->createToken('Test');

        $this->info($token->plainTextToken);

        return Command::SUCCESS;
    }
}
