<?php

namespace App\Http\Controllers;

use App\Role;
use App\RoleFunctionPermission;
use App\User;
use Illuminate\Http\Request;

class PermissionController extends HomeController
{
    protected $name = 'Permission';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     return parent::index($request);
    // }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $Roles = Role::get();
        $columns = [
            ['key' => '用户姓名', 'sortable' => false],
        ];
        foreach ($Roles as $Role) {
            $columns[] = [
                'key' => $Role->name,
                'sortable' => false,
            ];
        }
        $parameters['columns'] = json_encode($columns);
        return $parameters;
    }

    function list() {
        $Roles = Role::get();
        $Users = User::with(['UserRole', 'UserRole.Role'])->get();
        $user_rows = [];
        foreach ($Users as $User) {
            $user_cols = ['用户姓名' => $User->name];
            foreach ($Roles as $Role) {
                $user_cols[$Role->name] = [
                    'user_id' => $User->id,
                    'role_id' => $Role->id,
                    'grant' => false,
                ];
            }
            foreach ($User->UserRole as $UserRole) {
                $user_cols[$UserRole->Role->name]['grant'] = true;
            }
            $user_rows[] = $user_cols;
        }
        $RoleFunctionPermissions = RoleFunctionPermission::with(['_Function', 'Permission'])->get();
        return json_encode([
            // 'Roles' => $Roles,
            'Users' => $user_rows,
            'RoleFunctionPermissions' => $RoleFunctionPermissions,
        ], JSON_UNESCAPED_UNICODE);
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
