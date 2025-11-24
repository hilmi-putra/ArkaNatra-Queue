<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessCredentialModel;

class AccessCredentialSeeder extends Seeder
{
    public function run(): void
    {
        $credentials = [
            [
                'customer_id' => 1,

                'access_web' => 'https://customer1.com',
                'username_web' => 'admin1',
                'password_web' => 'pass123',

                'akses_ojs' => 'https://ojs.customer1.com',
                'username_ojs' => 'ojsadmin',
                'password_ojs' => 'ojs123',

                'akses_cpanel' => 'https://cpanel.customer1.com',
                'username_cpanel' => 'cpaneluser',
                'password_cpanel' => 'cpanelpass',

                'akses_webmail' => 'https://webmail.customer1.com',
                'username_webmail' => 'mail1',
                'password_webmail' => 'mailpass',

                'server' => 'rumahweb',
                'note' => 'Primary access',
                'expiration_date' => now()->addMonths(6),
            ],
            [
                'customer_id' => 2,

                'access_web' => 'https://customer2.com',
                'username_web' => 'user2',
                'password_web' => 'secret',

                'akses_ojs' => null,
                'username_ojs' => null,
                'password_ojs' => null,

                'akses_cpanel' => 'https://cpanel.customer2.com',
                'username_cpanel' => 'cp2',
                'password_cpanel' => 'cp2pass',

                'akses_webmail' => null,
                'username_webmail' => null,
                'password_webmail' => null,

                'server' => 'rumahweb',
                'note' => 'Backup access',
                'expiration_date' => now()->addMonths(12),
            ],
        ];


        foreach ($credentials as $item) {
            AccessCredentialModel::create($item);
        }
    }
}
