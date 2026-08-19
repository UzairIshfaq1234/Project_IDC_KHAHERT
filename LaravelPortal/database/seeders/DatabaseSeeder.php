<?php

namespace Database\Seeders;

use App\Models\idc_admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        idc_admin::create([
            'Name'      => 'Admin',
            'Username'  => 'admin',
            'Email'     => 'admin@idc.com',
            'Password'  => 'Admin@123',
            'Role'      => 1,
            'Contactno' => '00000000000',
            'Image'     => '',
        ]);

        idc_admin::create([
            'Name'      => 'Lab Technician',
            'Username'  => 'labtech',
            'Email'     => 'labtech@idc.com',
            'Password'  => 'LabTech@123',
            'Role'      => 2,
            'Contactno' => '00000000000',
            'Image'     => '',
        ]);

        idc_admin::create([
            'Name'      => 'Pathologist',
            'Username'  => 'pathologist',
            'Email'     => 'pathologist@idc.com',
            'Password'  => 'Path@123',
            'Role'      => 3,
            'Contactno' => '00000000000',
            'Image'     => '',
        ]);
    }
}
