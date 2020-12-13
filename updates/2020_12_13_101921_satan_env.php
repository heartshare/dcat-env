<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SatanEnv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('satan_env');
            Schema::create('satan_env',function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('env_key','255')
                ->comment('环境key')
                ->nullable(false);
            $table->string('env_value',255)
                ->comment('环境值')
                ->nullable(false);
            $table->string('created_at',255)
                ->comment('创建时间')
                ->nullable(false);
            $table->string('updated_at',255)
                ->comment('更新时间')
                ->nullable(false);
        });
        $row = \Dcat\Admin\Satan\Env\Library\SatanEnv::getEnv();
        foreach ($row as $item=>$value)
        {
            \Dcat\Admin\Satan\Env\Models\Env::query()
                ->create([
                    'env_key'=>$item,
                    'env_value'=>$value
                ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('satan_env');
    }
}
