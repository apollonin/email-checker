<?php

namespace Seredenko\Exceptions;


class BadConfigException extends \Exception
{
	protected $message = 'Bad or empty config';
}