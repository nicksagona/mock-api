<?php

namespace Mock\Api\Http\Controller;

use Mock\Api\Model;

class IndexController extends AbstractController
{

    /**
     * Users action
     *
     * @return void
     */
    public function users()
    {
        $userModel = new Model\User();
        $fields    = (null !== $this->request->getQuery('fields')) ? $this->request->getQuery('fields') : [];
        $page      = (null !== $this->request->getQuery('page')) ? (int)$this->request->getQuery('page') : null;
        $sort      = (null !== $this->request->getQuery('sort')) ? $this->request->getQuery('sort') : null;
        $filter    = (null !== $this->request->getQuery('filter')) ? $this->request->getQuery('filter') : null;
        $limit     = (null !== $this->request->getQuery('limit')) ? (int)$this->request->getQuery('limit') : null;

        $results = [
            'results'      => $userModel->getAll($page, $limit, $sort, $filter, $fields),
            'result_count' => $userModel->getCount($filter)
        ];

        $this->send($results);
    }

    /**
     * Users count action
     *
     * @return void
     */
    public function usersCount()
    {
        $userModel = new Model\User();
        $filter    = (null !== $this->request->getQuery('filter')) ? $this->request->getQuery('filter') : null;
        $this->send(['result_count' => $userModel->getCount($filter)]);
    }

    /**
     * Error action
     *
     * @return void
     */
    public function error()
    {
        $this->send(['error' => 'Resource not found.'], 404);
    }

}