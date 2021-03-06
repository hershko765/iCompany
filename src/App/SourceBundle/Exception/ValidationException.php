<?php
namespace App\SourceBundle\Exception;

use Symfony\Component\HttpKernel\Exception;

/**
 * AccessDeniedHttpException.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ValidationException extends Exception\HttpException
{
    public $errors;

	/**
	 * Constructor.
	 *
	 * @param string     $message  The internal exception message
	 * @param \Exception $previous The previous exception
	 * @param int        $code     The internal exception code
	 */
	public function __construct($errors, $message = 'Validation Failed', \Exception $previous = null, $code = 0)
	{
        $this->errors = $errors;
		parent::__construct(412, $message, $previous, [], $code);
	}
}