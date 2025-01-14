<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     *  path="/api/auth/login",
     *         tags={"User"},
     *         @OA\RequestBody(
     *          description="User's credentials",
     *          @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(
     *                   @OA\Property(
     *                            property="email",
     *                            type="string",
     *                            example="leopold.kuhic@example.com"
     *                   ),
     *                        @OA\Property(
     *                             property="password",
     *                             type="string",
     *                             example="password"
     *                    ),
     *              ),
     *         )
     *      ),
     *  @OA\Response(
     *     response="200",
     *     description="Get a JWT via given credentials",
     *         @OA\MediaType(
     *               mediaType="application/json",
     *                @OA\Schema(
     *                    @OA\Property(
     *                             property="access_token",
     *                             type="string",
     *                             example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3BvcnRhbHRlc3QyLnJ1L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzM2ODUwNTM5LCJleHAiOjE3MzY4NTQxMzksIm5iZiI6MTczNjg1MDUzOSwianRpIjoiRWZ5U1liTGhJMWlMbVNYSCIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.9766eqWuUCqI-993e6nCPohNrQfUFk6v1DRDtqoFqLA"
     *                    ),
     *                     @OA\Property(
     *                              property="token_type",
     *                              type="string",
     *                              example="bearer"
     *                     ),
     *                     @OA\Property(
     *                               property="expires_in",
     *                               type="integer",
     *                               example=3600
     *                      ),
     *               ),
     *        ),
     *   )
     * )
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $_GET['refresh_token'] = $token;

        return response()->json([
                                    'access_token' => $token,
                                    'token_type' => 'bearer',
                                    'expires_in' => auth()->factory()->getTTL() * 60
                                ]);
    }
}
