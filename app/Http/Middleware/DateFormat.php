<?php namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class DateFormat {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		Carbon::setToStringFormat('d/M/Y');
		return $next($request);
	}

}
