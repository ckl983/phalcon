<?php
/**
 * Created by PhpStorm.
 * User: odin
 * Date: 2019-03-29
 * Time: 12:08
 */

use WPLib\Base\Model;

class BaseModel extends Model
{
    /**
     * 统计
     *
     * @param null $parameters
     * @return mixed
     */
    public static function count($parameters = null)
    {
        if (isset($parameters[0]) && is_array($parameters[0])) {
            $conditions = $parameters[0];
            unset($parameters[0]);
        } elseif (isset($parameters['conditions']) && is_array($parameters['conditions'])) {
            $conditions = $parameters['conditions'];
            unset($parameters['conditions']);
        }

        if (isset($conditions)) {
            $parameters['bind'] = isset($parameters['bind']) ? $parameters['bind'] : [];
            $where = '';
            foreach ($conditions as $k => $v) {
                $where .= (!empty($where) ? " and " : "") . "{$k} = :{$k}:";
                $parameters['bind'][$k] = $v;
            }
            $parameters[0] = $where;
        }
        try {
            return parent::count($parameters);
        } catch (\Exception $e) {
            $modelName = get_called_class();
            (new $modelName())->ensureConnection(self::MODE_CONNECTION_READ);
        }

        return parent::count($parameters);
    }

    /**
     * 按条件获取列表
     *
     * @param array $params
     * @return array
     */
    public static function getList($params = array(), $withPage = 1)
    {
        $res = [
            'list' => [],
        ];

        $total = self::count([$params['conditions']]);
        $res['total'] = $total;
        if ($total < 1) {
            return [];
        }
        $res['offset'] = !empty($params['offset']) ? $params['offset']: 0;
        $res['limit'] = !empty($params['limit']) ? $params['limit']: 20;
        $res['total_pages'] = ceil($total / $res['limit']);

        $res['list'] = self::find($params)->toArray() ? : [];

        return $res;
    }


    /**
     * 软删除单条记录
     *
     * @param array $conditions
     * @return array
     */
    public static function softDelete($conditions = array())
    {
        $ret = ['code' => 0, 'message' => ''];

        //查询油品是否存在
        $row = self::findFirst([
            'conditions' => $conditions
        ]);
        if ($row === false) {
            $ret = Constant::getErrorInfo(Constant::COMMON_DB_SELECT_FAIL);
            return $ret;
        }

        $data = [
            'is_delete' => 1,
            'update_time' => time(),
        ];

        if (!parent::modify($data, $conditions)) {
            $ret = Constant::getErrorInfo(Constant::COMMON_DB_DELETE_FAIL);
            return $ret;
        }

        return $ret;
    }

}
