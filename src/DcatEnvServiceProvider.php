<?php

namespace Dcat\Admin\Satan\Env;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class DcatEnvServiceProvider extends ServiceProvider
{
    protected $menu=[
        ['title'=>'edit-env','uri'=>'dcat-env/index','icon'=>'feather icon-edit']
    ];
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
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
