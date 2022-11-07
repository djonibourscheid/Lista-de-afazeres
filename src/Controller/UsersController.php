<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function incialize(): void
    {
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout('home');

        // Permitido acessar sem autentificação:
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        return $this->redirect(['controller' => 'Todos', 'action' => 'index']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // Evitar erros
        if (is_null($id)) {
            $this->Authorization->skipAuthorization();
            $this->Flash->error(__('Nenhum usuário foi solicitado. Tente novamente.'), ['clear' => true]);
            return $this->redirect(['action' => 'index']);
        }

        $this->loadComponent('Paginator');

        $user = $this->Users->get($id, [
            'contain' => ['Todos'],
        ]);

        $this->Authorization->authorize($user);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setLayout('loginAndRegister');

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi salvo.'), ['clear' => true]);

                return $this->redirect(['controller' => 'Todos', 'action' => 'index']);
            }
            $this->Flash->error(__('O usuário não pôde ser salvo. Tente novamente.'), ['clear' => true]);
        }
        $this->set(compact('user'));
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setLayout('loginAndRegister');

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            // redirect to /todos (/) after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Todos',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('E-mail ou senha incorreta.'), ['clear' => true]);
        }
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();

        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // Evitar erros
        if (is_null($id)) {
            $this->Authorization->skipAuthorization();
            $this->Flash->error(__('Nenhum usuário foi solicitado. Tente novamente.'), ['clear' => true]);
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->Authorization->authorize($user);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi salvo. Para ver as alterações, faça login novamente.'), ['clear' => true, 'key' => 'user']);

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('O usuário não pôde ser salvo. Tente novamente.'), ['clear' => true, 'key' => 'user']);
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // Evitar erros
        if (is_null($id)) {
            $this->Authorization->skipAuthorization();
            $this->Flash->error(__('Nenhum usuário foi solicitado. Tente novamente.'), ['clear' => true]);
            return $this->redirect(['action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->get($id);
        $this->Authorization->authorize($user);

        // Deleta os to dos do usuário e deleta o usuário
        if (
            $this->Users->Todos->deleteAll(['user_id' => $user->id]) &
            $this->Users->delete($user)
        ) {
            $this->Flash->success(__('O usuário foi deletado.'), ['clear' => true]);
        } else {
            $this->Flash->error(__('O usuário não pôde ser deletado. Tente novamente.'), ['clear' => true, 'key' => 'user']);
            return $this->redirect(['action' => 'view', $id]);
        }

        return $this->redirect(['action' => 'logout']);
    }
}
