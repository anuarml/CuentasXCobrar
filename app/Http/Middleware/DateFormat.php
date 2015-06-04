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
		setlocale(LC_ALL,'esm');
		//Carbon::setToStringFormat('d/M/Y');
		//Carbon::setToStringFormat('%d/%b/%Y');
		return $next($request);
	}

}
