<?php

namespace Dcat\Admin\Satan\Env;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Satan\Env\Library\SatanEnv;

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
        //全局注册
		$this->app->singleton(SatanEnv::class,function ($app){
		    return new SatanEnv($app);
        });
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
