<?php

namespace Cms\Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class AuthAdminMiddleware
{
    /**
     * The guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('pxcms.user.login'))
                    ->withError(trans('auth::auth.permissions.authenticated'));
            }
        }

        if (!$this->auth->user()->isAdmin()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect(route('pxcms.pages.home'))
                    ->withError(trans('auth::auth.permissions.unauthorized'));
            }
        }

        return $next($request);
    }
}
