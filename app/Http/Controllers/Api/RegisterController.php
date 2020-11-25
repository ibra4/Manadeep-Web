<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();

        $input['phone_number'] = $input['phone_number'];
        $input['password'] = bcrypt($input['password']);
        $input['name'] = $request->input('name');
        // @todo: Handle Verification 
        $input['verification_code'] = '1234';

        $user = User::create($input);

        $role = Role::select('id')->where('name', 'user')->first();
        $user->roles()->attach($role);

        $success = $this->getUserResponse($user, true);

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError([$request->phone_number], 'validation_error');
        }

        if (Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password])) {

            $user = Auth::user();

            $success = $this->getUserResponse($user);

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError([], 'validation_error');
        }

        $user = auth('api')->user();

        if ($user->is_active) {
            return $this->sendError([], 'user_already_active');
        }

        if ($user->verification_code == $request->input('verification_code')) {
            $user->is_active = true;
            $user->save();

            $success = $this->getUserResponse($user);
            return $this->sendResponse($success, 'user_activated_successfully.');
        } else {
            return $this->sendError([], 'invalid_verification_code');
        }
    }

    private function getUserResponse(User $user, $new = false)
    {
        $data = [
            'token' => $user->createToken('MyApp')->accessToken,
            'roles' => $user->roles()->get()->pluck('name')->toArray(),
            'is_active' => $user->is_active,
            'name' => $user->name,
            'phone' => $user->phone_number,
            'is_active' => $user->is_active,
        ];
        if ($new) {
            $data['verification_code'] = '1234';
        }

        return $data;
    }
}
