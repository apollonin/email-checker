<?php

namespace Seredenko\Exceptions;


class CurlDisableException extends \Exception
{
	protected $message = 'Curl extension not enabled';
}