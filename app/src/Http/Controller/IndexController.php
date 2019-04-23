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
        $limit     = (null !== $this->request->getQuery('limit')) ?
            (int)$this->request->getQuery('limit') : $this->application->config['pagination'];

        $results = [
            'results'      => $userModel->getAll($page, $limit, $sort, $filter, $fields),
            'result_count' => $userModel->getCount($filter)
        ];

        $this->send(200, $results, 'OK', $this->application->config['http_options_headers']);
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
        $this->send(
            200, ['result_count' => $userModel->getCount($filter)], 'OK', $this->application->config['http_options_headers']
        );
    }

    /**
     * Error action
     *
     * @return void
     */
    public function error()
    {
        $this->send(404, ['error' => 'Resource not found.']);
    }

}