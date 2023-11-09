<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use SoapClient;
use SoapHeader;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function user()
    {
        return Auth::user();
    }

    public function register(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'usuario' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'paises' => 'required|string|max:100',
            'password' => 'required|string|max:10',
            'color' => 'required|string|max:10',
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors()->all(),
                ],
                400
            ); //pongo el codigo de status
        }
        //si todo sale bien creamois registro
        $usuario = User::create([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'usuario' => $request->input('usuario'),
            'email' => $request->input('email'),
            'paises' => $request->input('paises'),
            'password' => Hash::make($request->input('password')),
            'color' => $request->input('color'),

        ]);
        $usuario->save();
        return response()->json(
            [
                'status' => true,
                'message' => 'Su usuario ha sido creado',
                'usuario' => $usuario,
                /* 'token' => $usuario->createToken('API TOKEN')->plainTextToken */
            ],
            200
        ); //pongo el codigo de status
    }

    /*  public function login(Request $request){   //EL LOGIN QUE ESTABA USANDO
    if(!Auth::attempt($request->only('usuario','password'))){
    return response([
    'message' => 'Sus credenciales son inválidas'
    ], Response::HTTP_UNAUTHORIZED);
    }
    $user = Auth::user();
    $token = $user->createToken('token')->plainTextToken; */
    /*si usamos  la capacidad de utilizar argumentos nombrados, lo que significa que puedes especificar
    el nombre de los argumentos al llamar a una función. Cuando utilizas argumentos nombrados, todos
    los argumentos siguientes también deben ser nombrados.*/
    /* $cookie = cookie(name:'jwt', value: $token, minutes:60*24);//es un día
    return response([
    'message' => 'Login exitoso'
    ], 200)->withCookie($cookie);
    } */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Sus credenciales son inválidas',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = User::where('usuario', $request->usuario)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('token')->accessToken;
                $user->update([
                    'sesion_iniciada' => 1,
                ]);
                $user->save();
                return response()->json([
                    "status" => 200,
                    "message" => "Usuario logeado correctamente!",
                    "access_token" => $token,
                    "auth_usuario" => $user,
                ]);
            } else {
                return response()->json([
                    "status" => 401,
                    "message" => "Alguno de los datos ingresados no son correctos.",
                ]);
            }
        } else {
            return response()->json([
                "status" => 401,
                "message" => "Usuario no registrado en ntras bases.",
            ]);
        }
    }

    public function logout($id)
    { // utilizar sesion_iniciada para comprobar que esta logueado y cerrar sesion
        $user = User::where('id', $id)->first();
        $user->update([
            'sesion_iniciada' => 0,
        ]);
        $user->save();

        return response()->json([
            "status" => 200,
            "message" => "Sesión cerrada",
        ]);
    }

    public function buscarPerfil(Request $request)
    {
        return response()->json([
            "status" => 200,
            "message" => "Acerca del perfil de usuario",
            "data" => $request->user(),
        ]);
    }

    public function redirectToAuth(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    public function handleAuthCallback(): JsonResponse
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (Exception $e) {
            echo '', $e->getMessage(), '';
        }

        /** @var User $user */
        $user = User::query()
            ->firstOrCreate(
                [
                    'google_id' => $socialiteUser->getId(),
                ],
                [
                    'nombre' => $socialiteUser->getName(),
                    'apellido' => $socialiteUser->user['apellido'] ?? null,
                    'usuario' => $socialiteUser->user['usuario'] ?? null,
                    'email' => $socialiteUser->getEmail(),
                    'paises' => $socialiteUser->user['paises'] ?? null,
                    'color' => $socialiteUser->user['color'] ?? null,
                    'sesion_iniciada' => 1,
                ]
            );

        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken('google-token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function getPaises()
    {
        if (extension_loaded('soap')) {
            // Procesar la respuesta SOAP
            // Iniciar el cliente
            $wsdl = 'http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL';
            $options = [
                "soap_version" => '1.2'
            ];

            $client = new SoapClient($wsdl, $options);
            
            // Especificar los headers
            $service = 'http://www.oorsprong.org/websamples.countryinfo';
            $headerbody = [
                'Host' => 'webservices.oorsprong.org',
                'Content-Type' => 'application/soap+xml; charset=utf-8'
            ];
            $header = new SoapHeader($service, 'RequestorCredentials', $headerbody);
            $client->__setSoapHeaders($header);

            // Realizamos la consulta a traves de $client
            $infoPaises = $client->__soapCall("FullCountryInfoAllCountries", []); // 2 formas distintas de usar los metodos
            // $infoPaises = $client->FullCountryInfoAllCountries();

            return response()->json(['message' => 'Solicitud SOAP exitosa', 'data' => $infoPaises]);
        } else {
            return response()->json(['message' => 'Cliente SOAP no está habilitado'], 500);
        }
    }
}
