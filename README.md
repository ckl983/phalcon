PHALCON脚手架


### 目录结构

```
app_falsework/
|-- console
|   `-- cli.php
|-- v1.0
|   |-- composer.json
|   |-- composer.lock
|   |-- config
|   |   |-- bootstrap.php
|   |   |-- config.php
|   |   |-- environ
|   |   |   |-- develop.php
|   |   |   |-- preview.php
|   |   |   |-- production.php
|   |   |   `-- test.php
|   |   |-- loader.php
|   |   |-- router.php
|   |   `-- services.php
|   |-- controllers
|   |   |-- BaseController.php
|   |   `-- DefaultController.php
|   |-- logics
|   |   `-- BaseLogic.php
|   |-- models
|   |   `-- Mongo
|   |       `-- Counters.php
|   |-- tasks
|   |   `-- DemoTask.php
|   |-- tests
|   |   |-- bootstrap.php
|   |   |-- phpunit.xml
|   |   |-- Test
|   |   |   `-- testsDemoUnitTest.php
|   |   `-- UnitTestCase.php
|   `-- vendor
|       |-- autoload.php
|       `-- composer
|           |-- autoload_classmap.php
|           |-- autoload_namespaces.php
|           |-- autoload_psr4.php
|           |-- autoload_real.php
|           |-- autoload_static.php
|           |-- ClassLoader.php
|           |-- installed.json
|           `-- LICENSE
`-- webroot
    |-- favicon.ico
    `-- index.php

```

### 设置

> 请修改app_falsework为你自己的项目名称，如：app_dispatcher
>
> 修改webroot/index.php, config/config.php中的相关配置，如app_id、app_name、db配置等
>
> 修改config/environ/下的环境配置
>
> 修改config/config.php中的数据库及其他相关配置

#### 路由设置

##### 修改config/router.php文件

栗子一：

```
$router->add(
    "/:namespace/:controller/:action/:params",
    [
        "namespace"  => 1,
        "controller" => 2,
        "action"     => 3,
        "params"     => 4,
    ]
);
```

栗子二：

```
$router->add(
    "/a/b/c/:controller/:action/:params",
    [
        "namespace"  => "\\a\\b\\c",
        "controller" => 1,
        "action"     => 2,
        "params"     => 3,
    ]
);
```

### MongoDB的使用

#### Model定义

> 为区分Mysql与Mongo，Mongo模型使用命名空间Mongo

```
<?php

/**
 *
 * @author --
 * @copyright 2014-2018  
 */

namespace Mongo;

use WPLib\Mvc\Collection;

class LogSystemLogs extends Collection
{
    public function getSource()
    {
        return "wei_log_system_logs";
    }
}
```

### Mysql的使用

#### Model定义

```
<?php

/**
 *
 * @author --
 * @copyright 2014-2018  
 */

class OrderItemInspay extends \WPLib\Base\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $item_id;

    /**
     *
     * @var integer
     */
    public $update_time;

    /**
     *
     * @var integer
     */
    public $create_time;

    public static $readConnectionService = "db_read";

    public static $writeConnectionService = "db";

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        
        $this->setSource("wei_order_item_inspay");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'wei_order_item_inspay';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderItemInspay[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderItemInspay
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}
```


#### ORM

> 定义好Model以后，可以使用跟Mysql模型的大部分方法，如：find/findFirst/save/update/delete等，更多请[查看手册](http://docs.iphalcon.com/zh/latest/index.html)

栗子一：

```
$device = Devices::findFirst([
        'conditions' => [
            'id' => 1001,
            'is_delete' => 0,
        ],
    ]);
/*
$device = Devices::findFirstById(1001);
*/

if ($device === false) {
    // 不存在
} else {
    // ...
}
```

栗子二：

```
$device = Devices::find([
        'conditions' => [
            'type'      => 1001,
            'is_delete' => 0,
        ],
    ]);

if ($device->count() > 0) {
    foreach ($device as $k => $v) {
        // ...
    }
}
```

栗子三：

```
    $manager = $this->getDI()->get('modelsManager');
    $builder = $manager->createBuilder()
        ->from('Devices')
        ->where('is_delete=0')
        ->orderBy('create_time ASC');

    if (isset($params['merchant_type']) && isset($params['merchant_id'])) {
        $builder->andWhere('((merchant_type=:merchant_type: AND merchant_id=:merchant_id:) OR (last_login_merchant_type=:merchant_type: AND last_login_merchant_id=:merchant_id:))', ['merchant_type' => $params['merchant_type'], 'merchant_id' => $params['merchant_id']]);
    }

    if (isset($params['status']) && in_array($params['status'])) {
        $builder->inWhere('status', $params['status']);
    }

    if (isset($params['search_key'])) {
        $builder->andWhere('device_sn LIKE :search_key: OR device_number LIKE :search_key:', ['search_key' => "%{$params['search_key']}%"]);
    }
    
    $device = $builder->getQuery()
        ->execute();
        
    $device_list = $device->toArray();
```

或

```
    $manager = $this->getDI()->get('modelsManager');
    $builder = $manager->createBuilder()
        ->from('Devices')
        ->where('is_delete=0');

    if (isset($params['merchant_type']) && isset($params['merchant_id'])) {
        $builder->andWhere('((merchant_type=:merchant_type: AND merchant_id=:merchant_id:) OR (last_login_merchant_type=:merchant_type: AND last_login_merchant_id=:merchant_id:))', ['merchant_type' => $params['merchant_type'], 'merchant_id' => $params['merchant_id']]);
    }

    if (isset($params['status']) && in_array($params['status'])) {
        $builder->inWhere('status', $params['status']);
    }

    if (isset($params['search_key'])) {
        $builder->andWhere('device_sn LIKE :search_key: OR device_number LIKE :search_key:', ['search_key' => "%{$params['search_key']}%"]);
    }
    
    $paginator = new Paginator([
        'builder' => $builder,
        'limit'   => $limit,
        'page'    => $page,
    ]);

    $pagination = $paginator->getPaginate();

    // $pagination->items = $pagination->items->toArray();
```


#### 视图


```
$this->view->setVar('abc', 1);
```

指定模板

```
$this->view->pick('setting/account/role/index');
```
