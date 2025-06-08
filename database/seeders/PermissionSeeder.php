<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $timestamp = Carbon::now();
        DB::table("permissions")->delete();

        $permissions = [

            // İstifadəçilər
            [
                'name' => 'users.index',
                'guard_name' => 'web',
                'permssion_title' => 'İstifadəçiləri görüntülə',
                'group_name' => 'İstifadəçilər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'users.create',
                'guard_name' => 'web',
                'permssion_title' => 'Yeni istifadəçi yarat',
                'group_name' => 'İstifadəçilər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'users.edit',
                'guard_name' => 'web',
                'permssion_title' => 'İstifadəçini dəyişdir',
                'group_name' => 'İstifadəçilər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'users.delete',
                'guard_name' => 'web',
                'permssion_title' => 'İstifadəçini sil',
                'group_name' => 'İstifadəçilər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],


            [
                'name' => 'logo-managements.index',
                'guard_name' => 'web',
                'permssion_title' => 'Logo idarəetməsi görüntülə',
                'group_name' => 'Logo idarəetməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'logo-managements.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Logo idarəetməsi dəyişdir',
                'group_name' => 'Logo idarəetməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],


            [
                'name' => 'role-permissions.index',
                'guard_name' => 'web',
                'permssion_title' => 'Rol İcazələri görüntülə',
                'group_name' => 'Rol İcazələri',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'role-permissions.create',
                'guard_name' => 'web',
                'permssion_title' => 'Rol İcazələri yarat',
                'group_name' => 'Rol İcazələri',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'role-permissions.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Rol İcazələri dəyişdir',
                'group_name' => 'Rol İcazələri',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'role-permissions.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Rol İcazələri sil',
                'group_name' => 'Rol İcazələri',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],



            [
                'name' => 'role-managements.index',
                'guard_name' => 'web',
                'permssion_title' => 'Rol idarəetməsi görüntülə',
                'group_name' => 'Rol idarəetməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'role-managements.create',
                'guard_name' => 'web',
                'permssion_title' => 'Rol idarəetməsi yarat',
                'group_name' => 'Rol idarəetməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'role-managements.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Rol idarəetməsi dəyişdir',
                'group_name' => 'Rol idarəetməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'role-managements.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Rol idarəetməsi sil',
                'group_name' => 'Rol idarəetməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],



            [
                'name' => 'oil_change_types.index',
                'guard_name' => 'web',
                'permssion_title' => 'Yağın dəyişilmə növü görüntülə',
                'group_name' => 'Yağın dəyişilmə növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'oil_change_types.create',
                'guard_name' => 'web',
                'permssion_title' => 'Yağın dəyişilmə növü yarat',
                'group_name' => 'Yağın dəyişilmə növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'oil_change_types.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Yağın dəyişilmə növü dəyişdir',
                'group_name' => 'Yağın dəyişilmə növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'oil_change_types.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Yağın dəyişilmə növü sil',
                'group_name' => 'Yağın dəyişilmə növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            




            [
                'name' => 'cities.index',
                'guard_name' => 'web',
                'permssion_title' => 'Şəhərlər görüntülə',
                'group_name' => 'Şəhərlər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'cities.create',
                'guard_name' => 'web',
                'permssion_title' => 'Şəhərlər yarat',
                'group_name' => 'Şəhərlər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'cities.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Şəhərlər dəyişdir',
                'group_name' => 'Şəhərlər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'cities.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Şəhərlər sil',
                'group_name' => 'Şəhərlər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            

            [
                'name' => 'oil-types.index',
                'guard_name' => 'web',
                'permssion_title' => 'Yanacaq növü görüntülə',
                'group_name' => 'Yanacaq növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'oil-types.create',
                'guard_name' => 'web',
                'permssion_title' => 'Yanacaq növü yarat',
                'group_name' => 'Yanacaq növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'oil-types.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Yanacaq növü dəyişdir',
                'group_name' => 'Yanacaq növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'oil-types.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Yanacaq növü sil',
                'group_name' => 'Yanacaq növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],


            [
                'name' => 'ban-types.index',
                'guard_name' => 'web',
                'permssion_title' => 'Ban növü görüntülə',
                'group_name' => 'Ban növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'ban-types.create',
                'guard_name' => 'web',
                'permssion_title' => 'Ban növü yarat',
                'group_name' => 'Ban növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'ban-types.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Ban növü dəyişdir',
                'group_name' => 'Ban növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'ban-types.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Ban növü sil',
                'group_name' => 'Ban növü',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            

            [
                'name' => 'brands.index',
                'guard_name' => 'web',
                'permssion_title' => 'Marka görüntülə',
                'group_name' => 'Marka',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'brands.create',
                'guard_name' => 'web',
                'permssion_title' => 'Marka yarat',
                'group_name' => 'Marka',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'brands.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Marka dəyişdir',
                'group_name' => 'Marka',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'brands.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Marka sil',
                'group_name' => 'Marka',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],


            [
                'name' => 'models.index',
                'guard_name' => 'web',
                'permssion_title' => 'Model görüntülə',
                'group_name' => 'Model',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'models.create',
                'guard_name' => 'web',
                'permssion_title' => 'Model yarat',
                'group_name' => 'Model',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'models.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Model dəyişdir',
                'group_name' => 'Model',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'models.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Model sil',
                'group_name' => 'Model',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],


            [
                'name' => 'vehicles.index',
                'guard_name' => 'web',
                'permssion_title' => 'Avtomobillər görüntülə',
                'group_name' => 'Avtomobillər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'vehicles.create',
                'guard_name' => 'web',
                'permssion_title' => 'Avtomobillər yarat',
                'group_name' => 'Avtomobillər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'vehicles.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Avtomobillər dəyişdir',
                'group_name' => 'Avtomobillər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'vehicles.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Avtomobillər sil',
                'group_name' => 'Avtomobillər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],


            [
                'name' => 'technical-reviews.index',
                'guard_name' => 'web',
                'permssion_title' => 'Texniki baxış görüntülə',
                'group_name' => 'Texniki baxış',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'technical-reviews.create',
                'guard_name' => 'web',
                'permssion_title' => 'Texniki baxış yarat',
                'group_name' => 'Texniki baxış',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'technical-reviews.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Texniki baxış dəyişdir',
                'group_name' => 'Texniki baxış',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'technical-reviews.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Texniki baxış sil',
                'group_name' => 'Texniki baxış',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'name' => 'insurances.index',
                'guard_name' => 'web',
                'permssion_title' => 'Siğorta görüntülə',
                'group_name' => 'Siğorta',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'insurances.create',
                'guard_name' => 'web',
                'permssion_title' => 'Siğorta yarat',
                'group_name' => 'Siğorta',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'insurances.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Siğorta dəyişdir',
                'group_name' => 'Siğorta',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'insurances.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Siğorta sil',
                'group_name' => 'Siğorta',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],


              [
                'name' => 'oil-changes.index',
                'guard_name' => 'web',
                'permssion_title' => 'Yağın dəyişilməsi görüntülə',
                'group_name' => 'Yağın dəyişilməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'oil-changes.create',
                'guard_name' => 'web',
                'permssion_title' => 'Yağın dəyişilməsi yarat',
                'group_name' => 'Yağın dəyişilməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'oil-changes.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Yağın dəyişilməsi dəyişdir',
                'group_name' => 'Yağın dəyişilməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'oil-changes.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Yağın dəyişilməsi sil',
                'group_name' => 'Yağın dəyişilməsi',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],


            [
                'name' => 'drivers.index',
                'guard_name' => 'web',
                'permssion_title' => 'Sürücülər görüntülə',
                'group_name' => 'Sürücülər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'drivers.create',
                'guard_name' => 'web',
                'permssion_title' => 'Sürücülər yarat',
                'group_name' => 'Sürücülər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
             [
                'name' => 'drivers.edit',
                'guard_name' => 'web',
                'permssion_title' => 'Sürücülər dəyişdir',
                'group_name' => 'Sürücülər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'drivers.delete',
                'guard_name' => 'web',
                'permssion_title' => 'Sürücülər sil',
                'group_name' => 'Sürücülər',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'name' => 'dashboard.index',
                'guard_name' => 'web',
                'permssion_title' => 'Dashboard görüntülə',
                'group_name' => 'Dashboard',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            
        ];

    DB::table('permissions')->insertOrIgnore($permissions);
    }
}
