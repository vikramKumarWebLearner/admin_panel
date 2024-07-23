<?php

namespace App\Http\Controllers;

// use App\DataTables\RoleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends AppBaseController
{
    /** @var  PermissionRepository */
    private $permissionRepository;

    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo, PermissionRepository $permissionRepo)
    {
        $this->roleRepository = $roleRepo;
        $this->permissionRepository = $permissionRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param RoleDataTable $roleDataTable
     * @return Response
     */
    // public function index(RoleDataTable $roleDataTable)
    // {
    //     return $roleDataTable->render('roles.index');
    // }

    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Role::select(DB::raw('ROW_NUMBER() OVER (ORDER BY roles.id) as serial_no'), 'roles.*', DB::raw('COUNT(model_has_roles.role_id) as role_count'))
                ->leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->groupBy('roles.id', 'roles.name', 'roles.guard_name', 'roles.created_at', 'roles.updated_at', 'roles.title', 'roles.description', 'roles.deleted_at');

            $sortColumn = $request->input('order.0.column');
            $sortColumnName = $request->input('columns.'.$sortColumn.'.data');
            $sortDirection = $request->input('order.0.dir');

            if($sortColumn == 0){
                $data->orderBy('created_at', 'desc');
            }

            if (!empty($sortColumnName)) {
                $data->orderBy($sortColumnName, $sortDirection);
            }

            return Datatables::of($data)
                ->filter(function ($data) use ($request) {
                    if (!empty($request->get('search'))) {
                        $data->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('roles.name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->make(true);
        }
        return view('roles.index');
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        $allPermission = $this->permissionRepository->all();
        return view('roles.create')->with('allPermission', $allPermission);
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {

        $input = $request->all();

        $permission_data = $request->get('permission_data');
        $role = $this->roleRepository->create($input);
        $role->syncPermissions($permission_data);

        Flash::success(__('models/roles.messages.create_success', ['model' => __('models/roles.singular')]));

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error(__('models/roles.messages.not_found', ['model' => __('models/roles.singular')]));

            return redirect(route('roles.index'));
        }

        $allPermission = $this->permissionRepository->all();
        return view('roles.show')->with('role', $role)->with('allPermission', $allPermission);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error(__('models/roles.messages.not_found', ['model' => __('models/roles.singular')]));

            return redirect(route('roles.index'));
        }

        $allPermission = $this->permissionRepository->all();

        return view('roles.edit')->with('role', $role)->with('allPermission', $allPermission);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int              $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error(__('models/roles.messages.not_found', ['model' => __('models/roles.singular')]));

            return redirect(route('roles.index'));
        }
        $permission_data = $request->get('permission_data');
        $role = $this->roleRepository->update($request->all(), $id);
        $role->syncPermissions($permission_data);

        Flash::success(__('models/roles.messages.update_success', ['model' => __('models/roles.singular')]));

        $allPermission = $this->permissionRepository->all();
        // return view('roles.show')->with('role', $role)->with('allPermission', $allPermission);
        return redirect(route('roles.index'));
        // return redirect()->route('roles.show', [$id]);
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    // public function destroy($id)
    // {
    //     $role = $this->roleRepository->find($id);
    //     if (empty($role)) {
    //         Flash::error('Role not found');
    //         return redirect(route('roles.index'));
    //     }
    //     $this->roleRepository->delete($id);
    //     Flash::success('Role deleted successfully.');
    //     return redirect(route('roles.index'));
    // }

    public function destroy($id) {
        $role = $this->roleRepository->find($id);
        if (empty($role)) {
            Flash::error(__('models/roles.messages.not_found', ['model' => __('models/roles.singular')]));
            return redirect(route('roles.index'));
        }
        $this->roleRepository->delete($id);

        Flash::success(__('models/roles.messages.delete_success', ['model' => __('models/roles.singular')]));

        return response()->json(['status' => 400]);
    }
}
