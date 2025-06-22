<?php

/**
 * NuraStats - Open source and privacy-friendly web analytics.
 * https://nurastats.com
 *
 * Copyright (c) Chimilevschi Iosif Gabriel
 * LICENSE:
 * Permissions of this strongest copyleft license are conditioned on making available complete source code 
 * of licensed works and modifications, which include larger works using a licensed work, under the same license. 
 * Copyright and license notices must be preserved. Contributors provide an express grant of patent rights. 
 * When a modified version is used to provide a service over a network, the complete source code of the modified version must be made available.
 *    
 * @copyright   Copyright (c) Chimilevschi Iosif Gabriel
 * @license     https://opensource.org/license/agpl-v3  AGPL-3.0 License.
 * @author      Chimilevschi Iosif Gabriel <office@nurasoftware.com>
 */

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Artisan;
use App\Models\Config;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Install extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows to install the app directly through CLI';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {

        if (Config::get_config('installed_at')) {
            $this->error('NuraStats is already installed.');
            return;
        }

        $this->line('Setup database tables');
        Artisan::call('migrate');
        $this->info('Database tables - ok');

        $this->line('Adding administrator account');
        $admin_name = $this->askValid('Input administrator full name: ', 'admin_name', ['required', 'min:3']);
        $admin_email = $this->askValid('Input administrator email: ', 'admin_email', ['required', 'email']);
        $admin_pass = $this->askValid('Input administrator password: ', 'admin_pass', ['required', 'min:5']);
        User::updateOrInsert(['email' => $admin_email], [
            'name' => $admin_name ?? 'Admin',
            'email' => $admin_email,
            'role' => 'admin',
            'password' => Hash::make($admin_pass),
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);

        Config::add_config('installed_at', now());

        $this->info('The install was successful!');
    }


    protected function askValid($question, $field, $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }


    protected function validateInput($rules, $fieldName, $value)
    {
        $validator = Validator::make([
            $fieldName => $value
        ], [
            $fieldName => $rules
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}
