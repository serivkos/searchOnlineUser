<?php

/**
 * @author Sergey Ivanov
 */
class IndexController
{

    /**
     * подсчем юзеров группе
     *
     * @return array
     */
    public function syncAction()
    {
        require PATH_TO_MODELS . 'Group.php';

        $groupModel = new Group();

        return $groupModel->vkGroupToDbSync();
    }

    /**
     * @return array
     */
    public function getListAction()
    {
        require PATH_TO_MODELS . 'Group.php';

        $groupModel = new Group();

        return $groupModel->getList();
    }

    /**
     * @return boolean
     */
    public function addAction()
    {

        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            return;
        }

        if (empty($_POST['groupId']) || !isset($_POST['descripption']))
        {
            return ['error' => 'groupId or descripption is empty'];
        }

        require PATH_TO_MODELS . 'Group.php';

        $groupModel = new Group();

        return $groupModel->add($_POST['groupId'], $_POST['descripption']);
    }

    /**
     * удаление группы
     * @return boolean
     */
    public function deleteAction()
    {
        if (empty($_POST['groupId']))
        {
            return FALSE;
        }

        require PATH_TO_MODELS . 'Group.php';

        $groupModel = new Group();

        return $groupModel->delete($_POST['groupId']);

    }

}