<?php


namespace Dcat\Admin\Satan\Env\Library;
use Illuminate\Support\Str;

class SatanEnv
{
    /**
     * 删除某个配置
     * @param $key
     * @return bool|void
     */
    public static function delete($key)
    {
        $key = self::resolving($key);
        if (!self::has($key))return false;
        $env = self::load();
        unset($env[$key]);
        return self::save($env);
    }
    /**
     * 获取env列表
     * @param null $key
     * @return array|mixed
     */
    public static function getEnv($key=null)
    {
        $env = self::load();
        $key = is_null($key)?$key:self::resolving($key);
        if (!is_null($key) && !empty($env[$key]))return $env[$key];
        return $env;
    }
    public static function batchSet($key)
    {
        foreach ($key as $item=>$value)
        {
            self::set($item,$value);
        }
    }

    /**
     * 新增
     * @param $key
     * @param $value
     * @return bool|void
     */
    public static function add($key,$value)
    {
        if (self::has($key)) return self::set($key,$value);
        $key = self::resolving($key);
        $env = self::load();
        $env[$key]=$value;
        return self::save($env);
    }
    /**
     * 设置env变量
     * @param $key
     * @param $name
     * @return bool|void
     */
    public static function set($key,$value)
    {
        if (!self::has($key)) return false;
        //解析key
        $key=self::resolving($key);
        $data = self::getEnv();
        $data[$key]=$value;
        return self::save($data);
    }

    /**
     * 解析key是否存在
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return !empty(self::load()[self::resolving($key)]);
    }
    /**
     * 解析字符串
     * @param $str string key值
     * @return string
     */
    public static function resolving($str)
    {
        if (empty($str))return $str;
        //将所有字母转换为大小写
        $str = strtoupper($str);
        //将.转换为_
        $str = str_replace('.','_',$str);
        return  $str;
    }
    /**
     * 读取env文件，保留以#开头的注释
     *
     * @param  string $path 文件路径
     * @param  string $file 文件名，默认".env"
     *
     * @return array
     */
    public static function load()
    {
        // 拼接文件
        $filePath = self::getEnvPath();
        if (!is_readable($filePath) || !is_file($filePath)) {
            throw new \InvalidArgumentException(
                'The file "' . $filePath . '" not readable or not found'
            );
        }
        // 在读取在 Macintosh 电脑中或由其创建的文件时， 如果 PHP 不能正确的识别行结束符，启用运行时配置可选项 auto_detect_line_endings 也许可以解决此问题。
        // 读取当前auto_detect_line_endings设置
        $autodetect = ini_get('auto_detect_line_endings');
        // 开启auto_detect_line_endings
        ini_set('auto_detect_line_endings', '1');
        // 把env文件读取到数组中
        $lines = file($filePath, FILE_IGNORE_NEW_LINES);
        // 还原auto_detect_line_endings
        ini_set('auto_detect_line_endings', $autodetect);
        $envData = [];
        foreach ($lines as $line) {
            // 保留以#开头的注释
            if (strpos(trim($line), '#') === 0) {
                $envData[] = $line;
                continue;
            }
            // 转化成数组
            if (strpos($line, '=') !== false) {
                list($name, $value) = array_map('trim', explode('=', $line, 2));
                $envData[$name] = $value;
            }
        }
        return $envData;
    }
    /**
     * 保存数据到env文件中，同时保留注释
     *
     * @param  array  $envData 要保存的数据
     * @param  string $path 文件路径
     * @param  string $file 文件名，默认".env"
     *
     * @return void|bool
     */
    public static function save(array $envData)
    {
        // 拼接文件
        $filePath = self::getEnvPath();
        if (!is_writable($filePath) || !is_file($filePath)) {
            throw new \InvalidArgumentException(
                'The file "' . $filePath . '" not writable or not found'
            );
        }
        $env = '';
        foreach ($envData as $key => $value) {
            if (is_numeric($key)) {
                $env .= $value;
            } else {
                $env .= $key . '=' . $value;
            }
            $env .= PHP_EOL;
        }
        if (file_put_contents($filePath, $env) === false) {
            throw new \InvalidArgumentException(
                'The file "' . $filePath . '" to save false'
            );
        }
        return true;
    }
    public static function getEnvPath()
    {
        return is_file(base_path('.env'))?base_path('.env'):false;
    }
}
