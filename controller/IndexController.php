<?php

/**
 * @author Sergey Ivanov
 */
class IndexController
{

    /**
     * подсчем юзеров группе
     */
    public function indexAction()
    {
        require PATH_TO_MODELS . 'Group.php';

        $groupModel = new Group();

        return $groupModel->vkGroupToDbSync();
    }

}