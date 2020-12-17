# Dcat Admin Extension edit env file
## 示例
![示例图-1](https://cdn.jsdelivr.net/gh/Death-Satan/cdn@master/20201216201753.png)
![示例图-2](https://cdn.jsdelivr.net/gh/Death-Satan/cdn@master/20201216201817.png)
### 2020年12月13日
- 快速进行动态编辑env文件
- 不区分大小写
- 快速删除
### 安装
```shell script
composer require death_satan/dcat-env
```
### 代码快捷使用
#### Facades
```php
//引入命名空间
use Dcat\Admin\Satan\Env\Facades\SatanEnv;

//使用方法 以下代码运行同理 
//将会对env文件追加一行 API_NAME=examples
//如果存在则修改
SatanEnv::add('api_name','examples');
SatanEnv::add('api.name','examples');
SatanEnv::add('API.name','examples');
SatanEnv::add('API_name','examples');
//检查key是否存在
SatanEnv::has('api.name');
//删除某一键值对
SatanEnv::delete('api.name');
//修改某一键值对 如果不存在则创建
SatanEnv::set('api.name','test');
//保存新的键值对到当前的env文件内
//注意 该方法会删除所有原本的键值对
SatanEnv::save(['app.name'=>'voice']);
```
#### 通过容器获取实例
```php
//获取实例
$env = app()->get(\Dcat\Admin\Satan\Env\Library\SatanEnv::class);
//添加
$env->add('ws.name','reload');
```





