<?php
use Bitrix\Main\Entity;
use Bitrix\Main\Entity\Query;

class CModel extends Entity\DataManager {
    /**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
    {
		return '';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
    {
		return [];
	}

    /**
     * Удаление записей (также групповое удаление)
     *
     * @param mixed $primary
     *
     * @return bool
     */
    public static function delete($primary)
    {
        if (!is_array($primary) && (int) $primary){
            return parent::delete($primary);
        }

        if ($ids = static::getIDs($primary)){
            foreach($ids as $id) {
                parent::delete($id);
            }

            return true;
        }
    }

    /**
     * Обновление записей
     *
     * @param mixed $mixed
     *
     * @return bool
     */
    public static function update($mixed, $data = [])
    {
        if (!is_array($mixed) && (int) $mixed){
            return parent::update($mixed, $data);
        }

        if ($ids = static::getIDs($mixed)){
            foreach($ids as $id) {
                parent::update($id, $data);
            }

            return true;
        }
    }

    /**
     * Возвращает хедер для админки
     * @return array
     */
    public static function getAdminListHeader($whatShow = null, $needSort = true)
    {
        $header = [];
        foreach (static::getMap() as $field => $info) {
            if (!isset($info['reference'])) {
                $header[] = [
                    'id' => $field,
                    'content' => $info['title'],
                    'default' => true,
                    'sort' => $needSort ? strtolower($field) : false
                ];
            }
        }

        if ($whatShow) {
            $result = [];
            foreach ($header as $h) {
                if (in_array($h["id"], $whatShow)) {
                    $result[] = $h;
                }
            }

            return $result;
        }

        return $header;
    }

    /**
     * Get empty array of fields
     *
     * @return array
     */
    public static function getEmpty()
    {
        $data = [];
        foreach (static::getMap() as $field => $info) {
            $data[$field] = null;
        }

        return $data;
    }

    /**
     * Check row in DB
     *
     * @param array $filter
     *
     * @return boolean
     */
    public static function CheckExists($filter = [])
    {
        $rs = static::GetList(["filter" => $filter])->Fetch();

        return $rs ? true : false;
    }

    /**
     * Transform data for DB
     *
     * @param array $inFields
     *
     * @return array
     */
    public static function prepareFields($inFields = [])
    {
        $fields = [];
        $map = static::getMap();
        foreach (self::filterFields($inFields) as $field => $value) {
            switch($map[$field]['data_type']){
                case 'date':
                case 'datetime':
                    $fields[$field] = $value ? new \Bitrix\Main\Type\DateTime(date("Y-m-d H:i:s", strtotime($value)), 'Y-m-d H:i:s') : null;
                    break;

                case "integer":
                    $value = $value ?: null;
                    $fields[$field] = $value;
                    break;

                default:
                    $fields[$field] = $value;
                    break;
            }
        }
        return $fields;
    }

    /**
     * Get array KEY => FIELD
     *
     * @param string $key
     * @param string $field
     * @param array $filter
     * @param array $sort
     * @param bool $needJoin
     *
     * @return array
     */
    public static function GetArray(
        $key = "ID",
        $field = "NAME",
        $filter = [],
        $sort = ["ID" => "ASC"],
        $needJoin = true
    ) {
        $all = static::GetAll($filter, $sort, null, 0, null, $needJoin);

        $result = [];
        $i = 0;
        foreach ($all as $ar){
            $result[ ($key ? $ar[$key] : $i++) ] = $field ? $ar[$field] : $ar;
        }

        return $result;
    }

    /**
     * Get array with IDs
     *
     * @param array $filter
     * @param array $order
     *
     * @return array
     */
    public static function getIDs($filter = [], $order = ["ID" => "ASC"])
    {
        $ids = [];
        $rs = static::GetList(["select" => ["ID"], "filter" => $filter, "order" => $order]);
        while ($ar = $rs->Fetch()) {
            $ids[] = $ar["ID"];
        }

        return $ids;
    }

    /**
     * Get rows in array
     *
     * @param array $filter
     * @param array $sort
     * @param integer $limit
     * @param integer $offset
     * @param string $group
     * @param bool $needJoin
     *
     * @return array
     */
    public static function GetAll(
        $filter = [],
        $sort = [],
        $limit = null,
        $offset = 0,
        $group = null,
        $needJoin = true
    ) {
        $result = [];

        $rs = static::GetAllRs($filter, $sort, $limit, $offset, $group, $needJoin);
        while ($ar = $rs->Fetch()) {
            $result[$ar["ID"]] = $ar;
        }

        return $result;
    }

    /**
     * Get rows in CDBResult object
     *
     * @param array $filter
     * @param array $sort
     * @param integer $limit
     * @param integer $offset
     * @param string $group
     * @param bool $needJoin
     *
     * @return CDBResult
     */
    public static function GetAllRs(
        $filter = [],
        $sort = [],
        $limit = null,
        $offset = 0,
        $group = null,
        $needJoin = true
    ) {
        $select = [];
        $map = static::getMap();
        foreach ($map as $key => $info){
            if (isset($info['reference'])){
                if ($needJoin) {
                    $f = current(array_keys($info['reference']));
                    $f = str_replace("=this.", "", $f) . "_";
                    $select[$f] = $key;
                }
            } else {
                $select[] = $key;
            }
        }

        $params = ['select' => $select, 'filter' => $filter, 'order' => $sort, "count_total" => true];

        if($limit) {
            $params['limit'] = $limit;
        }
        if($offset) {
            $params['offset'] = $offset;
        }
        if($group) {
            $params['group'] = $group;
        }

        return static::GetList($params);
    }

    /**
     * Get total count
     *
     * @param array $filter
     * @param string $group
     *
     * @return integer
     */
    public static function GetTotal($filter, $group = null)
    {
        $query = new Query(static::getEntity());
        $query->setFilter($filter);

        if ($group) {
            $query->setGroup($group);
        } else {
            $query->addSelect('ID');
        }

        $rs = $query->exec();

        return $rs->getSelectedRowsCount();
    }

    /**
     * Get row from DB
     * @param array $filter
     * @param boolean $needJoin
     * @return array | boolean
     */
    public static function Get($filter = [], $needJoin = true)
    {
        $item = current(static::GetAll($filter, [], null, 0, null, $needJoin));

        return $item ?: false;
    }

    /**
     * Upload file or files
     *
     * @param string $key
     * @param bool $isImage
     * @param bool $isMulti
     *
     * @return bool|array
     */
    public static function UploadFile($key, $isImage = false, $isMulti = false)
    {
        if ($isMulti) {
            $files = self::reArrayFiles($key);
            $ids = [];
            foreach ($files as $f){
                if ($isImage && !CFile::IsImage($f["name"], $f["type"])) {
                    return false;
                }

                $ids[] = CFile::SaveFile($f);
            }

            return $ids;
        }

        if (isset($_FILES[$key])) {
            if ($isImage && !CFile::IsImage($_FILES[$key]["name"], $_FILES[$key]["type"])) {
                return false;
            }

            return CFile::SaveFile($_FILES[$key]);
        }

        return false;
    }

    /**
     * Rearray $_FILES array for multiply uploading
     *
     * @param string $key
     *
     * @return array
     */
    public static function reArrayFiles($key)
    {
        if (!isset($_FILES[$key])) {
            return [];
        }

        $files = [];
        foreach (["name", "type", "tmp_name", "error", "size"] as $k) {
            foreach ($_FILES[$key][$k] as $i => $n) {
                $files[$i][$k] = $n;
            }
        }

        return $files;
    }
}