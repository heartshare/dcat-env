<?php


namespace Dcat\Admin\Satan\Env\Facades;

use Dcat\Admin\Satan\Env\Library\SaTanEnvInterface;

/**
 * Class SatanEnv
 * @package Dcat\Admin\Satan\Env\Facades
 * @see \Dcat\Admin\Satan\Env\Library\SatanEnv
 * @method static bool delete($key) 删除某个配置
 * @method static array getEnv($key=null) 获取env文件键值对
 * @method static bool add($key,$value) 新增键值对
 * @method static bool set($key,$value) 修改或者新增某一键值
 * @method static bool has($key) 解析key是否存在
 * @method static array load() 读取env文件，保留以#开头的注释
 * @method static bool save(array $envData) 保存数据到env文件中，同时保留注释
 */
class SatanEnv extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
     return \Dcat\Admin\Satan\Env\Library\SatanEnv::class;
    }
}
