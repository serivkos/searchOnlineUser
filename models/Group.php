<?php

require PATH_TO_MODELS . 'VkGroupIterator.php';

/**
 * @author Sergey Ivanov
 */
class Group
{

    /**
     * @var string
     */
    private $_table = 'groups';

    /**
     * @return \PDO
     */
    private function _getPdo()
    {
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' .DB_NAME .';charset=' .DB_CHARSET;

        return new \PDO($dsn, DB_USER, DB_PASSWORD, $opt);
    }

    /**
     * получаем юзеров в группе через итератор
     *
     * @param string $groupId
     * @return array
     */
    private function _getUserListFromGroup($groupId)
    {

        $iterator = new VkGroupIterator($groupId);

        $arrUsers = [];

        foreach ($iterator as $key => $value)
        {
            if (!is_array($value))
            {
                continue;
            }

            $arrUsers = array_merge($arrUsers, $value);
        }

        return $arrUsers;
    }

    /**
     * Получаем пользователей которые находятся online и offline
     *
     * @throws Exception
     */
    private function _getUsersOnlineFromGroup()
    {
        $arrDataGroups = [];

        $groupList = $this->_getPdo()->query('SELECT * FROM ' . $this->_table)->fetchAll(PDO::FETCH_ASSOC);

        if (empty($groupList))
        {
            throw new Exception('not found groups');
        }

        //получаем даные по api по каждой группе
        foreach ($groupList as &$group)
        {
            $group['users'] = $this->_getUserListFromGroup($group['group_id']);

            //считаем кол-во юзеров которые online в группе
            $online = 0;
            foreach ($group['users'] as $user)
            {
                if ($user['online'] == 1)
                {
                    $group['usersOnline'][] = $user;
                }
                else
                {
                    $group['usersOffline'][] = $user;
                }
            }
        }

        return $groupList;
    }

    /**
     * записывает данные в бд
     *
     * @param arrray $groupList
     */
    private function _updateDb($groupList)
    {
        $prepareInsert = $this
            ->_getPdo()
            ->prepare('INSERT INTO group_user
                (group_id, count_user, count_user_online, count_user_offline, date_insert)
                VALUES
                (:groupId, :countUser, :countUserOnline, :countUserOffline, :dateInsert)')
       ;

        foreach ($groupList as $group)
        {
            $prepareInsert
                ->execute([
                    ':groupId' => $group['id'],
                    ':countUser' => count($group['users']),
                    ':countUserOnline' => count($group['usersOnline']),
                    ':countUserOffline' => count($group['usersOffline']),
                    ':dateInsert'       => date('Y-m-d H:i:s')
                ])
            ;
        }
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * запись в бд данных об online пользователях в группах
     */
    public function vkGroupToDbSync()
    {
        $groupList = $this->_getUsersOnlineFromGroup();
        $this->_updateDb($groupList);
    }

    /**
     * получает данные о группах из бд
     */
    public function getList($dateStart = NULL, $dateEnd = NULL)
    {
        $where = ' WHERE date_insert < "' . (empty($dateEnd) ? date('Y-m-d H:i:s') : $dateEnd) . '"'
                . ' AND date_insert > "' . (empty($dateStart) ? date('Y-m-d H:i:s', 0) : $dateStart) . '"'
        ;

        return $this
            ->_getPdo()
            ->query('SELECT
                    g.group_id,
                    g.description,
                    gu.count_user_online,
                    gu.count_user_offline,
                    gu.count_user,
                    gu.date_insert
                FROM `groups` AS g
                LEFT JOIN group_user AS gu ON g.id = gu.group_id
            ' . $where . ' ORDER BY gu.date_insert')
            ->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_GROUP)
        ;
    }

    /**
     * @param string $groupId
     * @param string $descripption
     * @return boolean
     */
    public function add($groupId, $descripption)
    {
        $bExists = $this->_getPdo()->query('SELECT 1 FROM groups WHERE group_id = ' . $this->_getPdo()->quote($groupId))->fetchColumn();

        if ($bExists)
        {
            return ['error' => 'group is alrady exists'];
        }

        $this
            ->_getPdo()
            ->prepare('INSERT INTO groups (group_id, description) VALUES (:groupId, :description)')
            ->execute([
                ':groupId' => $groupId,
                ':description' => $descripption
            ])
       ;

       return ['success' => TRUE];
    }

    public function delete($groupId)
    {
        $rowGroup = $this->_getPdo()->query('SELECT * FROM groups WHERE group_id = ' . $this->_getPdo()->quote($groupId))->fetch(PDO::FETCH_ASSOC);

        if (!is_array($rowGroup))
        {
            return TRUE;
        }

        $this->_getPdo()
            ->query('DELETE FROM groups WHERE id = ' . $rowGroup['id'])
            ->execute()
        ;

        $this->_getPdo()
            ->query('DELETE FROM group_user WHERE group_id = ' . $rowGroup['id'])
            ->execute()
        ;

        return TRUE;
    }

}