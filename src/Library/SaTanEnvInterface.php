<?php


namespace Dcat\Admin\Satan\Env\Library;


interface SaTanEnvInterface
{
    /**
     * 删除某个配置
     * @param $key
     * @return bool|void
     */
    public  function delete($key);
    /**
     * 获取env列表
     * @param null $key
     * @return array|mixed
     */
    public  function getEnv($key=null);
    /**
     * 新增
     * @param $key
     * @param $value
     * @return bool|void
     */
    public  function add($key,$value);
    /**
     * 修改或者新增某一键值
     * @param $key
     * @param $name
     * @return bool|void
     */
    public  function set($key,$value);
    /**
     * 解析key是否存在
     * @param $key
     * @return bool
     */
    public  function has($key);
    /**
     * 读取env文件，保留以#开头的注释
     * @return array
     */
    public  function load();
    /**
     * 保存数据到env文件中，同时保留注释
     * @param  array  $envData 要保存的数据
     * @return void|bool
     */
    public  function save(array $envData);

}
