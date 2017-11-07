<?php

namespace Seredenko\ConfigProviders;


class ArrayConfigProvider implements IConfigProvider
{
	private $config = [];
	private $defaultConfig = ['host' => 'http://emailforsure.com/', 'connectionTimeout' => 3];

	public function __construct(array $config = [])
	{
		$this->config = $config ?: $this->defaultConfig;
	}

	public function getConfig()
	{
		return $this->config;
	}
}