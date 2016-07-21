<?php

/**
 * @author Sergey Ivanov
 */
class VkGroupIterator implements Iterator
{

    private $_url = 'http://api.vk.com/method/groups.getMembers?group_id=%groupId%&offset=%offset%&fields=online&version=5.9';

    private $_position;

    private $_data;

    private $_countUsers;

    private $_groupId;


    private function _getData()
    {
        $offset = $this->_position * 1000;

        $ch = curl_init(str_replace(['%groupId%', '%offset%'], [$this->_groupId, $offset], $this->_url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($json, true);

        $users = $data['response']['users'];

        $this->_countUsers = $data['response']['count'];
        $this->_data = $data['response']['users'];
    }

    /**
     * @param string $groupId
     */
    public function __construct($groupId)
    {
        $this->_position = 0;
        $this->_groupId = $groupId;
        $this->_getData($groupId);
    }

    /**
     * {@inheritDoc}
     * @see Iterator::current()
     */
    public function current()
    {
        return $this->_data;

    }

    /**
     * {@inheritDoc}
     * @see Iterator::next()
     */
    public function next()
    {
        $this->_position++;
        $this->data = $this->_getData();
    }

    /**
     * {@inheritDoc}
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * {@inheritDoc}
     * @see Iterator::valid()
     */
    public function valid()
    {
        if (is_int($this->_position) && $this->_countUsers > $this->_position * 1000)
        {
            return true;
        }
        return false;

    }

    /**
     * {@inheritDoc}
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        // TODO Auto-generated method stub

    }

}