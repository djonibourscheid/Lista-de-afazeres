<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Todo $todo
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?= $this->Html->css(['todos', 'todosAndUsers']) ?>

<div class="container">
    <div class="card">
        <?php
        echo $this->Form->create($todo);

        echo $this->Form->control('title', [
            'label' => ['text' => 'Título da tarefa'],
            'placeholder' => 'ex. Jogar bola'
        ]);

        echo $this->Form->control('body', [
            'label' => ['text' => 'Descrição da tarefa'],
            'placeholder' => '(opcional) | ex. Jogar bola com os amigos.'
        ]);

        echo $this->Flash->render();

        echo $this->Form->button(__('Editar'));
        echo $this->Form->end();
        ?>
    </div>

    <aside class="sidebar">
        <h4><?= __('Ações') ?></h4>

        <?= $this->Html->link(
            $this->Html->image('icon-home-blue.svg', ['alt' => 'Voltar para home', 'title' => 'Voltar para home']) . __('Voltar para home'),
            ['action' => 'index'],
            [
                'confirm' => __('Você perderá toda a alteração feita, deseja continuar?'),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ); ?>

        <?= $this->Html->link(
            $this->Html->image('icon-newtodo.svg', ['alt' => 'Nova tarefa', 'title' => 'Adicionar nova tarefa']) . __('Nova tarefa'),
            ['action' => 'add'],
            [
                'confirm' => __('Você perderá toda a alteração feita, deseja continuar?'),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ); ?>

        <?= $this->Form->postLink(
            $this->Html->image('icon-delete-blue.svg', ['alt' => 'Deletar tarefa', 'title' => 'Deletar tarefa']) . __('Deletar tarefa'),
            ['action' => 'delete', $todo->slug],
            [
                'confirm' => __('Você tem certeza que deseja deletar:   {0}?', $todo->title),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ) ?>
    </aside>
</div>