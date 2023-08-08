<?php

namespace Kin\Setting;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class SettingServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];
    protected $menu = [
        [
            'title' => 'Setting',
            'uri'   => 'setting',
            'icon'  => '', // 图标可以留空
        ],
    ];


	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		//

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
