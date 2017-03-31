<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use ResetsPasswords;


use Modules\Core\Entities\User;

class AuthController extends Controller
{
    public $data;

    function __construct()
    {
        $this->data = new \stdClass();
    }

    //--------------------------------------------------------
    public function login(Request $request)
    {

        if($request->has('forgotpassword'))
        {
            $response = User::resetPasswordEmail($request);

            if($response['status'] == 'success')
            {
                return redirect()->back()->with('flash_success', 'Instructions are sent to your email');
            } else
            {
                return redirect()->back()->with('flash_success', $response['errors']);
            }


        } else
        {
            $response = User::login($request);
            if($response['status'] == 'success')
            {
                if (Auth::user()->hasPermission('core', 'backend-login')) {

                    if(!isset($response['redirect_url']))
                    {
                        $response['redirect_url'] = \URL::route('core.backend.dashboard');
                    }
                    return redirect($response['redirect_url']);
                } else {
                    $response['status'] = 'failed';
                    $response['errors'][] = getConstant('permission.denied');
                    return redirect()->back()->withErrors($response['errors']);
                }
            }
        }



        return redirect()->back()->withErrors($response['errors']);
    }

    //--------------------------------------------------------
    public function passwordReset(Request $request, $token)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        $this->data->body_class = "animsition page-login-v3 layout-full site-menubar-fold";
        return view('core::frontend.password-reset')->with('token', $token)
            ->with('data', $this->data);


    }
    //--------------------------------------------------------
    public function postReset(Request $request)
    {


        $rules = array(
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        );

        $validator = \Validator::make( $request->toArray(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            if ($request->ajax()) {
                return response()->json($response);
            } else {
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }



        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password)
        {
            $user->password = bcrypt($password);
            $user->save();
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                $result['status'] = 'success';
                $result['errors'][]= 'Error';
                break;

            default:
                $result['status'] = 'failed';
                $result['errors']= ['email' => trans($response)];
                break;
        }

        if ($request->ajax()) {
            return response()->json($result);
        } else {

            if($result['status'] =='success')
            {
                return redirect()->route('core.frontend.login')->with('flash_success', 'Password has been reset');
            } else
            {
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
            }
        }

    }
    //--------------------------------------------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $redirect = $request->input('redirect_url', \URL::route('core.frontend.login'));
        $response['status'] = 'success';
        $response['redirect_url'] = $redirect;
        if ($request->ajax()) {
            return response()->json($response);
        } else {
            $request->session()->flash('flash_success', getConstant('core.backend.logout'));
            $return = redirect($response['redirect_url']);
            return $return;
        }
    }
    //--------------------------------------------------------
    //--------------------------------------------------------
    //--------------------------------------------------------
    //--------------------------------------------------------
}
