<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Colaborador;
use App\Administrador;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ColaboradorResource;
use App\Http\Resources\AdministradorResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required',
            'password' => 'required',
            'rol' => 'required|in:colaboradores,api',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function attemptLogin(Request $request): bool
    {
        if ($request->rol == 'colaboradores') {
            $user = Colaborador::where('usuario', $request->username)
            ->first();
        } else {
            $user = Administrador::where('username', $request->username)
                    ->first();
        }

        if (!$user) {
            return false;
        }

        if (!$user->estado) {
            return false;
        }

        if ($request->rol == 'colaboradores') {
            $token = Auth::guard('colaboradores')->claims([
                'rol' => 'colaboradores',
            ])->setTTL(1440)->attempt([
                'usuario' => $request->username,
                'password' => $request->password,
            ]);

        // $token = Auth::guard('colaboradores')->claims([
            //     'rol' => 'colaboradores',
            // ])->setTTL(1440)->attempt([
            //     'usuario' => $request->username,
            //     'password' => $request->password,
            // ]);
        } else {
            $token = Auth::guard('api')->claims([
                'rol' => 'api',
            ])->setTTL(1440)->attempt([
                'username' => $request->username,
                'password' => $request->password,
                ]);
        }

        if ($token) {
            Auth::guard($request->rol)->setToken($token);

            return true;
        }

        return false;
    }

    /**
     * Get failed request response.
     *
     * @param null
     */
    public function sendFailedLoginResponse(Request $request)
    {
        if ($request->username && $request->password) {
            return response()->json([
                'message' => 'Data inválida',
                'errors' => [
                    'username' => 'Las credenciales introducidas son incorrectas.',
                ],
            ],
            422);
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request): JsonResponse
    {
        $this->clearLoginAttempts($request);

        $token = (string) Auth::guard($request->rol)->getToken();
        $expiration = Auth::guard($request->rol)->getPayload()->get('exp');

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration - time(),
            'user' => $request->rol == 'api' ? new AdministradorResource(Auth::guard($request->rol)->user()) : new ColaboradorResource(Auth::guard($request->rol)->user()),
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username(): string
    {
        return 'username';
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::guard($request->rol)->logout();

        return response()->json(['message' => 'Sesión cerrada.']);
    }
}
