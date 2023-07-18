<?php

namespace App\Services;

use App\Models\FirebaseToken;
use App\Models\User;
use App\Traits\DefaultImage;
use App\Traits\GeneralTrait;
use App\Traits\PhotoTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\{CompanyResource, UserResources};

class AuthService
{
    use DefaultImage,GeneralTrait,PhotoTrait;
    public function login($request)
    {
        $rules = [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'email.exists' => 411,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    411 => 'Failed,phone not exists',
                ];
                $code = (int)collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = $request->validate($rules);
        $data['role_id'] = 1;
//        $credentials = ['email' => $request->phone,'password' => '123456'];

//        dd($credentials);
        if (! $token = auth()->attempt($data)) {
            return helperJson(null, 'there is no user', 406);
        }
        $user = User::where('email',$data['email']);
        $user = $user->firstOrFail();
        $token = JWTAuth::fromUser($user);
        $user->token = $token;

        return helperJson(new UserResources($user), 'login successfully');
    }//end fun

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register($request)
    {
        $rules = [
            'phone'  => [
                'required',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query
                        ->wherePhone($request->phone)
                        ->whereRoleId(1);
                }),
            ],
            'name' => 'required|min:2|max:191',
            'email'  => [
                'required',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query
                        ->whereEmail($request->phone)
                        ->whereRoleId(1);
                }),
            ],
            'address' => 'required',
            'experience' => 'required',
            'about_me' => 'required',
            'previous_experience' => 'required',
            'city_id' => 'required',
            'language_id' => 'nullable',
            'translation_type_id' => 'required',
            'password' => 'required|min:6',
            'provider_type' => 'required|in:1,2',
            'certificate_image' => 'required_if:provider_type,==,2',
            'location_image' => 'required_if:provider_type,==,1',
            'commercial_register_image' => 'required_if:provider_type,==,1',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'phone.unique' => 409,
//            'email.unique' => 410,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    409 => 'Failed,phone number already exists',
//                    410 => 'Failed,email already exists',
                ];
                $code = (int)collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return helperJson(null, $validator->errors()->first(), 422);
        }
        $data = $request->validate($rules);

        $data['certificate_image'] = '';
        $data['location_image'] = '';
        $data['commercial_register_image'] = '';
        $data['role_id'] = 1;
        $data['status'] = 0;
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage('users', $request->file('image'));
        }

        if ($request->hasFile('certificate_image')) {
            $data['certificate_image'] = $this->saveImage( $request->file('certificate_image'),'assets/uploads/users','image');
        }
        if ($request->hasFile('location_image')) {
            $data['location_image'] = $this->saveImage( $request->file('location_image'),'assets/uploads/users','image');
        }
        if ($request->hasFile('commercial_register_image')) {
            $data['commercial_register_image'] = $this->saveImage( $request->file('commercial_register_image'),'assets/uploads/users','image');
        }
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);


        if ($user) {
            if (!$token = JWTAuth::fromUser($user)) {
                return helperJson(null, 'there is no user', 430);
            }
        }
        $user->token = $token;

        return helperJson(new UserResources($user), 'register successfully');
    }//end fun

    public function update_profile($request){
        $user = Auth()->user();
        $validator = Validator::make($request->all(), [
            'phone'      => 'required|unique:users,phone,'.$user->id,
            'password'   => 'nullable',
            'language_id' => 'nullable',
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator,406);
        }

//        $validator = Validator::make($request->all(), [
//            'email' => 'required|email|unique:users,email,'.$user->id,
//        ]);
//        if ($validator->fails()) {
//            $code = $this->returnCodeAccordingToInput($validator);
//            return $this->returnValidationError($code, $validator,407);
//        }

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image',
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator,400);
        }

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $this->uploadFiles('users', $request->file('image'));
        }

        if($request->has('password')
            && $request->password != null){
            $data['password'] = Hash::make($request->password);
        }else{
            unset($data['password']);
        }


        $user->update($data);
        $token = JWTAuth::fromUser($user);
        $user->token = $token;

        return helperJson(new UserResources($user), 'Updated successfully');
    }//end fun

    public function delete_account($request)
    {
        $user = auth('user-api')->user();
        if(!isset($user)){
            return helperJson(null, 'This Account not found',404);
        }

        User::find($user->id)->delete();
        return helperJson(null, 'Account Deleted successfully',200);
    }//end fun


    public function insertToken($request)
    {
        $rules = [
            'phone_token' => 'required',
            'software_type' => 'required|in:android,ios,web'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    409 => 'Failed,phone number already exists',
                    410 => 'Failed,email already exists',
                ];
                $code = (int)collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return helperJson(null, $validator->errors(), 422);
        }
        $data = $request->validate($rules);

        $data['user_id'] = auth()->user()->id;

        $token = FirebaseToken::updateOrCreate($data);

        return helperJson($token, 'register successfully');
    }//end fun

    public function profile($request)
    {
        $user = auth()->user();

        $user['token'] = trim($request->headers->get('Authorization'), 'Bearer ');

       return helperJson(new UserResources($user), '');
    }

    public function profileWithPhone($request)
    {
        $rules = [
            'phone' => 'required|exists:users,phone',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'phone.exists' => 411,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    411 => 'Failed,phone not exists',
                ];
                $code = (int)collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors()->first(), 'code' => 422], 200);
        }
        $data = $request->validate($rules);

        $user = User::where('phone',$data['phone']);
        $user = $user->firstOrFail();
        $token = JWTAuth::fromUser($user);
        $user->token = $token;

        return helperJson(new UserResources($user), 'User Profile Data');
    }//end fun
}
