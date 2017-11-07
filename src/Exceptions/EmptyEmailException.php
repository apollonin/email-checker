<?php

namespace Seredenko\Exceptions;


class EmptyEmailException extends \Exception
{
	protected $message = 'Empty email';
}