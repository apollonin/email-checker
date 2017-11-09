<?php

namespace Seredenko;

use Seredenko\ConfigProviders\ArrayConfigProvider;
use Seredenko\ConfigProviders\IConfigProvider;
use Seredenko\Exceptions\BadConfigException;
use Seredenko\Exceptions\CurlDisableException;
use Seredenko\Exceptions\EmptyEmailException;

class EmailChecker
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * EmailChecker constructor.
	 *
	 * @param IConfigProvider $config
	 */
	public function __construct(IConfigProvider $config)
	{
		$this->config = $config ? $config->getConfig() : (new ArrayConfigProvider())->getConfig();
	}

	/**
	 * Main function for validate email
	 *
	 * @param string $email
	 * @param boolean $allow_disposable
	 *
	 * @return array
	 */
	public function verify($email = '', $allow_disposable = false)
	{
		if (empty($email))
			throw new EmptyEmailException();

		if (!function_exists('curl_version'))
			throw new CurlDisableException();

		if (!array_key_exists('host', $this->config))
			throw new BadConfigException();

		$query = ['email' => $email];

		if ($allow_disposable)
			$query['allow_disposable'] = 'true';

		$url = $this->config['host'] . '/api/v1/verify?' . http_build_query($query);

		$ch = curl_init($url);

		curl_setopt_array($ch, [
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => $this->config['connectionTimeout']
		]);

		if( ! $result = curl_exec($ch))
		{
			trigger_error(curl_error($ch));
		}

		curl_close($ch);

		return json_decode($result, true);
	}
}