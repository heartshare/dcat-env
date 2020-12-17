<?php


namespace Dcat\Admin\Satan\Env\Library;
use Illuminate\Support\Str;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\Flysystem\Config;
use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;
use Dcat\Admin\Satan\Env\Library\SaTanEnvInterface;
/**
 * env操作类
 * Class SatanEnv
 * @package Dcat\Admin\Satan\Env\Library
 */
class SatanEnv implements SatanEnvInterface
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application $app
     */
    protected $app;
    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        $this->app = $app;
    }

    /**
     * 删除某个配置
     * @param $key
     * @return bool|void
     */
    public  function delete($key)
    {
        $key = $this->resolving($key);
        if (!$this->has($key))return false;
        $env = $this->load();
        unset($env[$key]);
        return $this->save($env);
    }
    /**
     * 获取env列表
     * @param null $key
     * @return array|mixed
     */
    public  function getEnv($key=null)
    {
        $env = $this->load();
        $key = is_null($key)?$key:$this->resolving($key);
        if (!is_null($key) && !empty($env[$key]))return $env[$key];
        return $env;
    }

    /**
     * 新增
     * @param $key
     * @param $value
     * @return bool|void
     */
    public  function add($key,$value)
    {
        if ($this->has($key)) return $this->set($key,$value);
        $key = $this->resolving($key);
        $env = $this->load();
        $env[$key]=$value;
        return $this->save($env);
    }
    /**
     * 设置env变量
     * @param $key
     * @param $name
     * @return bool|void
     */
    public  function set($key,$value)
    {
        if (!$this->has($key)) return $this->add($key);
        //解析key
        $key=$this->resolving($key);
        $data = $this->getEnv();
        $data[$key]=$value;
        return $this->save($data);
    }

    /**
     * 解析key是否存在
     * @param $key
     * @return bool
     */
    public  function has($key)
    {
        return !empty($this->load()[$this->resolving($key)]);
    }
    /**
     * 解析字符串
     * @param $str string key值
     * @return string
     */
    public  function resolving($str)
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
    public  function load()
    {
        // 拼接文件
        $filePath = $this->getEnvPath();
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
    public  function save(array $envData)
    {
        // 拼接文件
        $filePath = $this->getEnvPath();
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

    public  function getEnvPath()
    {
        return is_file(base_path('.env'))?base_path('.env'):false;
    }
}
