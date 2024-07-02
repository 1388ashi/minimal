<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Http\Requests\storeRequest;
use Modules\Admin\Http\Requests\updateRequest;
use Modules\Admin\Models\Admin;
use Modules\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function index(): Renderable
    {
        $admins = Admin::query()->paginate();

        return view('admin::admin.index', compact('admins'));
    }
    public function create(): Renderable
    {
        $roles = Role::select('id','name','label')->whereNot('name','super_admin')->get();

        return view('admin::admin.create', compact('roles'));
    }
    public function show(Admin $admin) {
        $logActivitys =  Activity::select('description','subject_type','event')->where('causer_id',$admin->id)->latest('id')->take(8)->get();
        $adminRolesName = $admin->getRoleNames()->first();

        return view('admin::admin.show', compact('adminRolesName','admin','logActivitys'));

    }
    public function store(storeRequest $request)
    {
        if (is_null($request->status)) {
            $request->status = false;
        }
        $admin = Admin::query()->create([
            'name' => $request->input('name'),
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'status' => $request->status
        ]);

        $admin->assignRole($request->role);

        $data = [
            'status' => 'success',
            'message' => 'ادمین با موفقیت ثبت شد'
        ];

        return redirect()->route('admin.admins.index')
        ->with($data);
    }

    public function edit(Admin $admin): Renderable
    {
            $adminRolesName = $admin->getRoleNames()->first();

            if ($adminRolesName == 'super_admin') {
                $roles = Role::select('id','name','label')->where('name','super_admin')->get();
            }else{
                $roles = Role::select('id','name','label')->whereNot('name','super_admin')->get();

            }
        return view('admin::admin.edit', compact('roles','adminRolesName','admin'));
    }
    public function update(updateRequest $request, Admin $admin)
    {
        if (is_null($request->status)) {
            $request->status = false;
        }

        $password = filled($request->password) ? $request->password : $admin->password;

        $admin->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'password' => Hash::make($password),
            'status' => $request->status
        ]);
        $admin->assignRole($request->role);

        Auth::logout();
        return redirect('/login');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $role = $admin->getRoleNames()->first();
        $admin->removeRole($role);
        $admin->delete();

        $data = [
            'status' => 'success',
            'message' => 'ادمین با موفقیت حذف شد'
        ];

        return redirect()->route('admin.admins.index')
            ->with($data);
    }
}
