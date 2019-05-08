<?php

namespace Mock\Api\Http\Controller;

use Mock\Api\Model;

class IndexController extends AbstractController
{

    /**
     * Index action
     *
     * @param  int $id
     * @return void
     */
    public function index($id = null)
    {
        if (null !== $id) {
            $user = (new Model\User())->getById($id);
            if (!isset($user['id'])) {
                $this->send(404);
            } else {
                $this->send(200, $user);
            }
        } else {
            $userModel = new Model\User();
            $page      = (null !== $this->request->getQuery('page')) ? (int)$this->request->getQuery('page') : null;
            $sort      = (null !== $this->request->getQuery('sort')) ? $this->request->getQuery('sort') : null;
            $limit     = (null !== $this->request->getQuery('limit')) ? (int)$this->request->getQuery('limit') : null;
            $filter    = (null !== $this->request->getQuery('filter')) ? $this->request->getQuery('filter') : null;
            $fields    = (null !== $this->request->getQuery('fields')) ? $this->request->getQuery('fields') : null;

            $results = $userModel->getAll($page, $limit, $sort, $filter, $fields);

            $results = [
                'page'         => $page,
                'sort'         => $sort,
                'limit'        => $limit,
                'filter'       => $filter,
                'fields'       => $fields,
                'total_count'  => $userModel->getCount($filter),
                'result_count' => count($results),
                'results'      => $results,
            ];

            $this->send(200, $results);
        }
    }

    /**
     * Create action
     *
     * @return void
     */
    public function create()
    {
        $user = (new Model\User())->save($this->request->getParsedData());
        if (!isset($user['id'])) {
            $this->send(400);
        } else {
            $this->send(200, $user);
        }
    }

    /**
     * Update action
     *
     * @param  int $id
     * @return void
     */
    public function update($id)
    {
        $user = (new Model\User())->update($id, $this->request->getParsedData());
        if (!isset($user['id'])) {
            $this->send(404);
        } else {
            $this->send(200, $user);
        }
    }

    /**
     * Delete action
     *
     * @param  int $id
     * @return void
     */
    public function delete($id = null)
    {
        $user = new Model\User();
        $data = $this->request->getParsedData();
        $code = 400;

        if (null !== $id) {
            $code = $user->delete($id);
        } else if (!empty($data['rm_users'])) {
            $code = $user->remove($data['rm_users']);
        }

        $this->send($code);
    }

    /**
     * Count action
     *
     * @return void
     */
    public function count()
    {
        $userModel = new Model\User();
        $filter    = (null !== $this->request->getQuery('filter')) ? $this->request->getQuery('filter') : null;
        $this->send(200, ['results_count' => $userModel->getCount($filter)]);
    }

    /**
     * Fields action
     *
     * @return void
     */
    public function fields()
    {
        $userModel = new Model\User();
        $this->send(200, ['fields' => $userModel->getSearchFields()]);
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