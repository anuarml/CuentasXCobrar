<?php namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		//dd($request);
		/*if($e instanceof ModelNotFoundException  && $e->getModel() == "App\Cxc"){
			$idPos = strrpos($request->getPathInfo(),"/");

			$id = substr($request->getPathInfo(), $idPos+1);

			dd("No existe el movimiento ".$id);
		}
		else*/ if($e instanceof \PDOException){

			\Log::error($e->getMessage());

			$errorMessage = 'sql.'.$e->getCode();

			if(\Lang::has($errorMessage)){
				$errors = ['sql' => trans($errorMessage)];
			}
			else{
				$errors = ['sql' => $e->getMessage()];
			}
			

			return response()->view('errors.sql',compact('errors'));
				//->withErrors(['sql' => trans('sql.'.$e->getCode())]);
		}
		else{
			return parent::render($request, $e);
		}

		//return parent::render($request, $e);
	}

}
