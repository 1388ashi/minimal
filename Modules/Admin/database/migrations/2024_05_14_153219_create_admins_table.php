<?php

use App\Traits\HasPermission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Models\Admin;

return new class extends Migration
{
    use Spatie\Permission\Traits\HasPermissions;
    use HasPermission;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile',12)->unique();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status');
            $table->rememberToken();
            $table->timestamps();
        });
        $superAdmin = Admin::query()->create([
            'name' => 'مدیر کل',
            'mobile' => '09334496439',
            'status' => true,
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);

        $this->makeRoles();
        $superAdmin->assignRole('super_admin');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
