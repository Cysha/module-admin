<?php namespace Cms\Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthAdminMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('pxcms.user.login'));
            }
        }

        if (!$this->auth->getUser()->isAdmin()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect(route('pxcms.admin.login'))
                    ->withError('Error: You need to be authenticated to get there, Or you do not have the neccesary permissions.');
            }
        }

        return $next($request);
    }

}
