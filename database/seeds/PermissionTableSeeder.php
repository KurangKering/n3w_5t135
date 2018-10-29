<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /*
        | Run command : 
        |php artisan cache:forget spatie.permission.cache
        |php artisan cache:clear  
        |
         */
        app('cache')->forget('spatie.permission.cache');
        $permissions = [
                'Administrator' => [
                    'user-list',
                    'user-create',
                    'user-edit',
                    'user-delete',
                    'role-list',
                    'role-create',
                    'role-edit',
                    'role-delete',
                ],
                'Ketua' => [
                    'laporan-list',
                    'history-list',
                ],
                'Member' => [
                    'mahasiswa-list',
                    'mahasiswa-create',
                    'mahasiswa-edit',
                    'mahasiswa-delete',
                    'pegawai-list',
                    'pegawai-create',
                    'pegawai-edit',
                    'pegawai-delete',
                    'pendaftaran-list',
                    'pendaftaran-create',
                    'pendaftaran-edit',
                    'pendaftaran-delete',
                    'pembayaran_semester-list',
                    'pembayaran_semester-create',
                    'pembayaran_semester-edit',
                    'pembayaran_semester-delete',
                    'pemasukan_lain-list',
                    'pemasukan_lain-create',
                    'pemasukan_lain-edit',
                    'pemasukan_lain-delete',
                    'pembayaran_gaji-list',
                    'pembayaran_gaji-create',
                    'pembayaran_gaji-edit',
                    'pembayaran_gaji-delete',
                    'pengeluaran_lain-list',
                    'pengeluaran_lain-create',
                    'pengeluaran_lain-edit',
                    'pengeluaran_lain-delete',
                ],

            ];
        foreach ($permissions as $permission) {
            foreach ($permission as $key => $value) {
                try {
                    $a_permission = Permission::firstOrCreate(['name' => $value]);

                } catch (Exception $e) {
                    $a_permission = $permission;
                }
            }

        }
        $this->command->info('Permissions Berhasil Ditambah.');
        foreach ($permissions as $index => $permission) {

            $role = Role::firstOrCreate(['name' => $index ]);
            $this->command->info('Role' . $index . ' Berhasil Ditambah.');
            $role->syncPermissions(Permission::whereIn('name', $permissions[$index] )->get());
            $this->command->info('Permissions  Berhasil Ditambah pada Role '. $index);
        }
        /**
         * create user default 
         * username : admin
         * email : admin
         * password : admin
         * sub bidang = -
         * 
         */
        $user['username'] = 'admin';
        $user['name'] = 'admin';
        $user['email'] = 'admin@admin.com';
        $password = 'asd';
        $pass = ($password); //secret
        $user['password'] = bcrypt($password); //secret
        $this->createUser($user, 'Administrator', $pass);

    }
    private function createUser($user, $role, $pass)
    {
        $user = User::updateOrCreate(['username' => $user['username']], 
            $user
        );
        $user->assignRole($role);
        $this->command->info('Data Login :');
        $this->command->warn('username : '.  $user->username);
        $this->command->warn('Password : ' . $pass);
        $this->command->info('===============================');

    }
}
