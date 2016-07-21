<?php

require PATH_TO_MODELS . 'VkGroupIterator.php';

/**
 * @author Sergey Ivanov
 */
class Group
{

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

        return new \PDO($dsn, 'root', 'web', $opt);
    }

    /**
     * рекурсивная функция по получению юзеров в группе
     *
     * @param string $groupId
     * @param intger $page
     * @return array
     */
    private function _getUserListFromGroup($groupId, $page = 1)
    {

        $iterator = new VkGroupIterator($groupId);

        foreach ($iterator as $key => $value)
        {
            var_dump($key);
            var_dump(1);
        }
echo 111;
        exit;
        $offset = ($page -1) * 1000;

        $url = 'http://api.vk.com/method/groups.getMembers?group_id=' . $groupId .'&offset=' . $offset . '&fields=online&version=5.9';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($json, true);

        $count = $data['response']['count'];
        $users = $data['response']['users'];

        if ($count > $page * 1000)
        {
            $users = array_merge($users, $this->_getUserListFromGroup($groupId, ++$page));
        }

        return $users;
    }

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
                    $online++;
                }
            }

            $group['usersOnline'] = $online;
            $group['usersOffline'] = count($group['users']) - $online;
        }

        return $groupList;
    }

    public function vkGroupToDbSync()
    {
        return $this->_getUsersOnlineFromGroup();
    }

}