<?php

namespace Modules\Permission\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Permission\Http\Requests\Admin\RoleStoreRequest;
use Modules\Permission\Http\Requests\Admin\RoleUpdateRequest;
use Modules\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private function permissions(): Collection
    {
        return Permission::query()
            ->oldest('id')
            ->select(['id', 'name', 'label'])
            ->get();
    }

    public function index()
    {
        $roles = Role::query()
        ->latest('id')
        ->select(['id', 'name', 'label', 'created_at'])
        ->paginate(15);

        return view('permission::admin.role.index', compact('roles'));
    }

    public function create(): Renderable
    {
        $permissions = $this->permissions();

        return view('permission::admin.role.create', compact('permissions'));
    }

    public function store(RoleStoreRequest $request): RedirectResponse
    {
        $role = Role::query()->create([
            'name' => $request->input('name'),
            'label' => $request->input('label'),
            'guard_name' => 'web'
        ]);

        $permissions = $request->input('permissions');
        if ($permissions) {
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        $data = [
            'status' => 'success',
            'message' => 'نقش با موفقیت ثبت شد'
        ];
        return redirect()->route('admin.roles')
        ->with($data);
    }
    public function edit(Role $role)
    {
        if ($role->name == 'super_admin') {
            Auth::logout();
            return redirect('/login');
        }
        $permissions = $this->permissions();

        return view('permission::admin.role.edit', compact('permissions', 'role'));
    }
    public function update(RoleUpdateRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->only(['name', 'label']));

        $permissions = $request->input('permissions');
        $role->syncPermissions($permissions);

        $data = [
            'status' => 'success',
            'message' => 'نقش با موفقیت به روزرسانی شد'
        ];
        return redirect()->route('admin.roles')
        ->with($data);
    }

    public function destroy(Role $role)
    {
        if ($role->admins) {
            $data = [
                'status' => 'danger',
                'message' => 'نقش به ادمینی وصل هست'
            ];
            return redirect()->route('admin.roles')->with($data);
        }
        $permissions = $role->permissions;

        if ($role->delete()) {
            foreach ($permissions as $permission) {
                $role->revokePermissionTo($permission);
            }
        }

        $data = [
            'status' => 'success',
            'message' => 'نقش با موفقیت حذف شد'
        ];

        return redirect()->route('admin.roles')
            ->with($data);
    }
}
