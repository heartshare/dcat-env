<?php

namespace Dcat\Admin\Satan\Env\Http\Controllers;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Satan\Env\Models\Env;

class DcatEnvController extends AdminController
{
    public function grid()
    {
        return Grid::make(new Env,function (Grid $grid){
            $grid->tools($grid->renderCreateButton());
            $grid->column('id');
            $grid->column('env_key');
            $grid->column('env_value');
            $grid->column('created_at');
            $grid->column('updated_at');
        });
    }
}
