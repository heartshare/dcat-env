<?php

namespace Dcat\Admin\Satan\Env\Http\Controllers;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Satan\Env\Library\SatanEnv;
use Dcat\Admin\Satan\Env\Models\Env;
use Dcat\Admin\Show;
use Illuminate\Support\Facades\Date;

class DcatEnvController extends AdminController
{
    public function grid()
    {
        return Grid::make(new Env,function (Grid $grid){
            $grid->model()->orderBy('id','desc');
            $grid->column('id');
            $grid->column('env_key');
            $grid->column('env_value');
            $grid->column('created_at');
            $grid->column('updated_at');
        });
    }

    public function form()
    {
        return Form::make(new Env(), function (Form $form) {
            $form->display('id');
            $form->text('env_key')->required(true);
            $form->text('env_value')->required(true);
            $form->saving(function (Form $form){
                $param = $form->input();
                $form->input('env_key',SatanEnv::resolving($param['env_key']));
                if ($form->isCreating())
                {
                    SatanEnv::add($param['env_key'],$param['env_value']);
                }elseif($form->isEditing()){
                    $data = $form->model()->toArray();
                    $env = SatanEnv::load();
                    unset($env[$data['env_key']]);
                    $param['env_key'] = SatanEnv::resolving($param['env_key']);
                    $env[$param['env_key']] = $param['env_value'];
                    SatanEnv::save($env);
                }elseif ($form->isDeleting())
                {
                    SatanEnv::delete($param['env_key']);
                }
                return $form;
            });
        });
    }
    public function detail($id)
    {
        return Show::make($id, new Env(), function (Show $show) {
            $show->field('id');
            $show->field('env_key');
            $show->field('env_value');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }
}
