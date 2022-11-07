<header>
  <h2><?php
      $controller = strtolower($this->request->getParam('controller'));
      $action = strtolower($this->request->getParam('action'));

      $confirm = null;
      if ($action == 'edit' || $action == 'add') {
        $confirm = __('Você perderá toda a alteração feita, deseja continuar?');
      };

      if ($controller == 'users') {
        echo $this->Html->link(
          __('Voltar para home'),
          ['controller' => 'Todos', 'action' => 'index'],
          [
            'title' => __('Voltar para home'),
            'confirm' => $confirm
          ]
        );
      } else {
        echo $this->Html->link(
          __('Olá, ' . h($user->name)),
          ['controller' => 'Users', 'action' => 'view', $user->id],
          [
            'title' => __('Ver suas informações'),
            'confirm' => $confirm
          ]
        );
      }
      ?></h2>

  <a href=<?= $this->Url->build(['controller' => 'logout']); ?> class="logout"> Sair <?= $this->Html->image('icon-logout.svg'); ?></a>
</header>