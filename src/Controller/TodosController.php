<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Todos Controller
 *
 * @property \App\Model\Table\TodosTable $Todos
 * @method \App\Model\Entity\Todo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TodosController extends AppController
{
    public function incialize(): void
    {
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('home');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $this->paginate = [
            'contain' => ['Users'],
            'limit' => 10,
            'cache' => false
        ];


        // Pegas as infos do usuario logado
        $user = $this->Authentication->getIdentity();

        // Search de to dos:
        // Pega a query da url
        $query = $this->request->getQuery('search');
        // Se existe algo, chama as tarefas do usuário com título parecido
        // Senão, chama todas tarefas
        if ($query) {
            $search = $this->Todos->find()->where(['user_id' => $user->id, 'title like' => '%' . $query . '%']);
        } else {
            $search = $this->Todos->find('all', [
                'conditions' => ['user_id' => $user->id],
                'cache' => false,
                'contain' => ['Users'],
            ]);
        }

        $todos = $this->paginate($search);

        // Para poder usar o empty($todos) na view
        if ($todos->isEmpty()) {
            $todos = [];
        }

        $this->set(compact('todos', 'user'));
    }

    /**
     * View method
     *
     * @param string|null $slug Todo slug.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {
        // Evitar erros
        if (is_null($slug)) {
            $this->Authorization->skipAuthorization();
            $this->Flash->error(__('Nenhuma tarefa foi solicitada. Tente novamente.'), ['clear' => true]);
            return $this->redirect(['action' => 'index']);
        }

        $todo = $this->Todos
            ->findBySlug($slug)
            ->firstOrFail();
        $this->Authorization->authorize($todo);

        // Pegas as infos do usuario logado, (usado no header)
        $user = $this->Authentication->getIdentity();

        $this->set(compact('todo', 'user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $todo = $this->Todos->newEmptyEntity();
        $this->Authorization->authorize($todo);

        // Pegas as infos do usuario logado
        $user = $this->Authentication->getIdentity();

        if ($this->request->is('post')) {
            $todo = $this->Todos->patchEntity($todo, $this->request->getData());

            // Defina o user_id do usuário atual.
            $todo->user_id = $user->getIdentifier();

            if ($this->Todos->save($todo)) {
                $this->Flash->success(__('A tarefa foi salva.'), ['clear' => true]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A tarefa não pôde ser salva. Tente novamente.'), ['clear' => true]);
        }


        $this->set(compact('todo', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $slug Todo slug.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($slug = null)
    {
        // Evitar erros
        if (is_null($slug)) {
            $this->Authorization->skipAuthorization();
            $this->Flash->error(__('Nenhuma tarefa foi solicitada. Tente novamente.'), ['clear' => true]);
            return $this->redirect(['action' => 'index']);
        }

        $todo = $this->Todos
            ->findBySlug($slug)
            ->firstOrFail();
        $this->Authorization->authorize($todo);

        if ($this->request->is(['post', 'put'])) {
            $todo = $this->Todos->patchEntity($todo, $this->request->getData(), [
                // Desativa modificação de user_id
                'accessibleFields' => ['user_id' => false]
            ]);

            if ($this->Todos->save($todo)) {
                $this->Flash->success(__('A tarefa foi salva.'), ['clear' => true]);

                return $this->redirect(['action' => 'view', $todo->slug]);
            }
            $this->Flash->error(__('A tarefa não pôde ser salva. Tente novamente.'), ['clear' => true]);
        }

        // Pegas as infos do usuario logado
        $user = $this->Authentication->getIdentity();

        $this->set(compact('todo', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $slug Todo slug.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($slug = null)
    {
        // Evitar erros
        if (is_null($slug)) {
            $this->Authorization->skipAuthorization();
            $this->Flash->error(__('Nenhuma tarefa foi solicitada. Tente novamente.'), ['clear' => true]);
            return $this->redirect(['action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);

        $todo = $this->Todos->findBySlug($slug)->firstOrFail();
        $this->Authorization->authorize($todo);



        if ($this->Todos->delete($todo)) {
            $this->Flash->success(__('A tarefa foi excluído.'), ['clear' => true]);
        } else {
            $this->Flash->error(__('A tarefa não pôde ser excluído. Tente novamente.'), ['clear' => true]);
        }

        $referer = $this->referer();

        if (str_starts_with($referer, '/users')) {
            return $this->redirect($referer);
        }
        return $this->redirect(['action' => 'index']);
    }
}

/* No delete, caso tenhamos mais controllers que possam deletar tarefas, podemos usar:
    $referer = $this->referer(); 
    // Output: '/users/view/123

    $refererController = substr($referer, 1, strpos($referer, '/', 1) - 1);
    // Output: 'users'

    switch ($refererController) {
        case 'users':
            # code...
            break;

        case 'todos':
            # code...
            break;

        case 'foobar':
            # code...
            break;

        default:
            # return padrão
            break;
    } 
*/