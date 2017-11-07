<?php

namespace Seredenko\ConfigProviders;


class JsonConfigProvider implements IConfigProvider
{
	private $config = [];
	private $defaultConfig = __DIR__ . '/../../config.json';

	public function __construct($config = '')
	{
		$this->config = $config ?: $this->defaultConfig;
	}

	public function getConfig()
	{
		return json_decode(file_get_contents($this->config), true);
	}
}