<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Notifications\SetPasswordNotification;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Response;
use DataTables;

class UserController extends AppBaseController {
	/** @var  UserRepository */
	private $userRepository;
	/** @var  RoleRepository */
	private $roleRepository;

	public function __construct(RoleRepository $roleRepo, UserRepository $userRepo) {
		$this->userRepository = $userRepo;
		$this->roleRepository = $roleRepo;
	}

	public function index(Request $request) {
        $roles = [];
        $roles = $this->roleRepository->all()->where('guard_name', 'web')->pluck('name', 'name');
        if ($request->ajax()) {
            $data = User::selectRaw('ROW_NUMBER() OVER (ORDER BY users.id) as serial_no, users.*, roles.name AS role_name')
                ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id');

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
                    if ($request->get('status') != '') {
                        $data->where('status', $request->get('status'));
                    }
                    if ($request->get('role_id') != '') {
                        $data->where('roles.name', $request->get('role_id'));
                    }
                    if (!empty($request->get('search'))) {
                        $data->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('users.name', 'LIKE', "%$search%")
                                ->orWhere('users.email', 'LIKE', "%$search%");
                        });
                    }
                })
                ->make(true);
        }
        return view('users.index')->with('roles', $roles);
    }

	public function create() {
		return view('users.create')->with('roles', $this->roleRepository->all()->pluck('name', 'id'));
	}

	public function store(CreateUserRequest $request) {
		$input = $request->all();

        /* remove this if you want to create password on create time. */
		//$input['password'] = Hash::make($request->password);

		$input['status'] = 'INACTIVE';
		$user = $this->userRepository->create($input);
        if($user){
            $role_data = $request->get('role_data');
            $user->syncRoles($role_data);

            $setPasswordToken = Password::createToken($user);
            $user->remember_token = $setPasswordToken;
            $user->save();

            $user->notify(new SetPasswordNotification($setPasswordToken));

            Flash::success(__('models/users.messages.create_success', ['model' => __('models/users.singular')]));
        }else{
            Flash::error(__('models/users.messages.create_error', ['model' => __('models/users.singular')]));
        }
		return redirect(route('users.index'));
	}

	public function show($id) {
		$user = $this->userRepository->find($id);
		if (empty($user)) {
            Flash::error(__('models/users.messages.not_found', ['model' => __('models/users.singular')]));
			return redirect(route('users.index'));
		}
		return view('users.show')->with('user', $user);
	}

	public function edit($id) {
		if ($id == 1) {
			Flash::error(__('models/users.messages.update_error', ['model' => __('models/users.singular')]));
			return redirect(route('users.index'));
		}

		$user = $this->userRepository->find($id);
		if (empty($user)) {
			Flash::error(__('models/users.messages.not_found', ['model' => __('models/users.singular')]));
			return redirect(route('users.index'));
		}
		return view('users.edit')->with('user', $user)->with('roles', $this->roleRepository->all()->pluck('name', 'id'));
	}

	public function update($id, UpdateUserRequest $request) {
		$user = $this->userRepository->find($id);

		if (empty($user)) {
			Flash::error(__('models/users.messages.not_found', ['model' => __('models/users.singular')]));
			return redirect(route('users.index'));
		}

		// $request['status'] = (!isset($request->status) ? 0 : 1);
		$requests = $request->all();
		$requests['email'] = $user->email;
		$user = $this->userRepository->update($requests, $id);
		$role_data = $request->get('role_data');
		$user->syncRoles($role_data);

        Flash::success(__('models/users.messages.update_success', ['model' => __('models/users.singular')]));
        return redirect(route('users.index'));
		// return redirect()->route('users.show', [$id]);
	}

	public function destroy($id) {
		$user = $this->userRepository->find($id);
		if (empty($user)) {
			$response = ['status' => 201,'message' => 'User not found'];
		} else {
			$this->userRepository->delete($id);
			$response = ['status' => 200,'message' => 'User deleted successfully.'];
		}
		return response()->json($response);
	}

	public function showProfile() {
		$user = auth()->user();
		return view('users.profile')->with('user', $user);
	}

    public function upload(Request $request)
    {
        $user = auth()->user();
        // dd(public_path('uploads'));
        $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('profile_images'), $filename);

        // Save the filename to your database or perform any other necessary actions

        $user->profile_image = $filename;
        $user->save();

        return response()->json(['image' => asset('uploads/' . $filename)]);
    }

	public function updateProfile(UpdateProfileRequest $request) {
		$id = auth()->user()->id;
		$data = $request->only(['name', 'email']);
		if ($request->get('password_new') && $request->get('password_new') != "") {
			$data['password'] = Hash::make($request->get('password_new'));
		}
		$this->userRepository->update($data, $id);
        Flash::success(__('models/users.messages.profile_success', ['model' => __('models/users.singular')]));
		return redirect(route('users.profile'));
	}

	public function changePassword(UpdatePasswordRequest $request) {
		$id = auth()->user()->id;
		// The passwords matches
		if (!Hash::check($request->get('current_password'), auth()->user()->password)) {
            Flash::success(__('models/users.messages.password_invalid', ['model' => __('models/users.singular')]));
			return redirect(route('users.profile', ['#change-Password']));
			// profile
		}
		// Current password and new password same
		if (strcmp($request->get('current_password'), $request->password_new) == 0) {
            Flash::success(__('models/users.messages.current_password_invalid', ['model' => __('models/users.singular')]));
			return redirect(route('users.profile', ['#change-Password']));
		}
		if ($request->get('password_new') && $request->get('password_new') != "") {
			$data['password'] = Hash::make($request->get('password_new'));
		}
		$this->userRepository->update($data, $id);
        Flash::success(__('models/users.messages.password_success', ['model' => __('models/users.singular')]));
		Auth::logout();
		return redirect()->intended('/login');
	}

	public function sendResetPasswordLink(Request $request) {
		$user = $this->userRepository->find($request->userId);
		if ($user) {
			$token = Password::createToken($user);
			$user->sendPasswordResetNotification($token);
			return response()->json(['message' => 'Reset password link sent successfully.']);
		}
	}

	public function sendSetPasswordEmail(Request $request) {
		$user = $this->userRepository->find($request->userId);

		if ($user) {
			$setPasswordToken = Password::createToken($user);
			$user->remember_token = $setPasswordToken;
			$user->save();
			$user->notify(new SetPasswordNotification($setPasswordToken));
			return response()->json(['message' => 'Set password link sent successfully.']);
		}
	}
}
