<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
        {
            $user = User::findOrFail($id);

            // إذا النموذج يحتوي على الاسم والبريد الإلكتروني → يعني تعديل كامل
            if ($request->has(['name', 'email'])) {
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email'],
                    'role' => ['required', 'exists:roles,name'],
                ]);

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                $user->syncRoles([$request->role]);

                return redirect()->route('users.show', $user)->with('success', 'تم تحديث بيانات المستخدم بنجاح');
            }

            // إذا فقط تغيير الدور (من جدول الإدارة)
            $request->validate([
                'role' => ['required', 'exists:roles,name'],
            ]);

            $user->syncRoles([$request->role]);

            return redirect()->back()->with('success', 'تم تحديث الدور بنجاح');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // حماية إضافية: لا تحذف نفسك أو مدير النظام الأساسي
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
