<?php

use App\Enums\RoleEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure roles exist
        foreach (RoleEnum::cases() as $role) {
            Role::findOrCreate($role->value, 'web');
        }

        // Migrate existing users to Spatie roles
        $users = DB::table('users')->select('id', 'role')->get();

        foreach ($users as $user) {
            $roleName = $user->role === 'admin' ? RoleEnum::Admin->value : RoleEnum::User->value;
            $role = Role::findByName($roleName, 'web');

            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_type' => 'App\\Models\\User',
                'model_id' => $user->id,
            ]);
        }

        // Drop the old role column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email');
        });

        // Restore role column from Spatie roles
        $adminRole = Role::where('name', RoleEnum::Admin->value)->first();

        if ($adminRole) {
            $adminUserIds = DB::table('model_has_roles')
                ->where('role_id', $adminRole->id)
                ->where('model_type', 'App\\Models\\User')
                ->pluck('model_id');

            DB::table('users')->whereIn('id', $adminUserIds)->update(['role' => 'admin']);
        }

        // Clean up Spatie role assignments for users
        DB::table('model_has_roles')
            ->where('model_type', 'App\\Models\\User')
            ->delete();
    }
};
