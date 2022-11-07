<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->assign('title', 'Editando: ' . __($user->name));
echo $this->Html->css(['users', 'todosAndUsers']);
?>


<div class="container">
    <div class="card">
        <?php echo $this->Form->create($user);

        echo $this->Form->control('name', [
            'label' => 'Nome',
            'placeholder' => 'ex. Djoni Bourscheid'
        ]);
        echo $this->Form->control('email', [
            'label' => 'E-mail',
            'placeholder' => 'ex. djonibourscheid@gmail.com',
            'autocapitalize' => "off",
        ]);
        echo $this->Form->control('password', [
            'label' => 'Senha',
            'placeholder' => 'Digite uma senha',
            'maxlength' => 255,
            'value' => '',
            'autocorrect' => "off",
            'autocapitalize' => "off",
            'autocomplete' => "on"
        ]);

        echo $this->Form->control('retype_password', [
            'label' => 'Confirmar senha',
            'placeholder' => 'Confirmar senha',
            'type' => 'password',
            'maxlength' => 255,
            'value'=>'',
            'autocorrect' => "off",
            'autocapitalize' => "off",
            'autocomplete' => "on"
        ]);

        echo $this->Flash->render('user');

        echo $this->Form->button(__('Editar'));
        echo $this->Form->end(); ?>
    </div>

    <aside class="sidebar">
        <h4><?= __('Ações') ?></h4>

        <?= $this->Html->link(
            $this->Html->image('icon-home-blue.svg', ['alt' => 'Voltar para home', 'title' => 'Voltar para home']) . __('Voltar para home'),
            ['controller' => 'Todos', 'action' => 'index'],
            [
                'confirm' => __('Você perderá toda a alteração feita, deseja continuar?'),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ); ?>

        <?= $this->Html->link(
            $this->Html->image('icon-newtodo.svg', ['alt' => 'Nova tarefa', 'title' => 'Adicionar nova tarefa']) . __('Nova tarefa'),
            ['controller' => 'Todos', 'action' => 'add'],
            [
                'confirm' => __('Você perderá toda a alteração feita, deseja continuar?'),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ); ?>

        <?= $this->Html->link(
            $this->Html->image('icon-arrow-left.svg', ['alt' => 'Voltar página', 'title' => 'Voltar página']) . __('Voltar página'),
            ['controller' => 'Users', 'action' => 'view', $user->id],
            [
                'confirm' => __('Você perderá toda a alteração feita, deseja continuar?'),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ); ?>

        <?= $this->Form->postLink(
            $this->Html->image('icon-delete-blue.svg', ['alt' => 'Deletar usuário', 'title' => 'Deletar usuário']) . __('Deletar usuário'),
            ['controller' => 'Users', 'action' => 'delete', $user->id],
            [
                'confirm' => __('Você tem certeza que deseja deletar o usuário:   {0}?', $user->name),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ) ?>
    </aside>
</div>