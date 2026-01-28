<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*', // Exclude API routes
    ];

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        // For serverless environments, be more lenient with CSRF
        if ($this->isReading($request) || $this->runningUnitTests() || $this->inExceptArray($request)) {
            return true;
        }

        $token = $this->getTokenFromRequest($request);

        // If no session token exists, regenerate one
        if (! $request->session()->token()) {
            $request->session()->regenerateToken();
        }

        return is_string($request->session()->token()) &&
            is_string($token) &&
            hash_equals($request->session()->token(), $token);
    }
}
