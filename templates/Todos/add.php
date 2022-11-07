<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Todo $todo
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<?= $this->Html->css(['todos', 'todosAndUsers']) ?>


<div class="container">
    <div class="card">
        <?php
        echo $this->Form->create($todo);

        echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
        echo $this->Form->control('slug', ['type' => 'hidden', 'value' => 1]);

        echo $this->Form->control('title', [
            'label' => ['text' => 'Título da tarefa'],
            'placeholder' => 'ex. Jogar bola'
        ]);

        echo $this->Form->control('body', [
            'label' => ['text' => 'Descrição da tarefa'],
            'placeholder' => '(opcional) | ex. Jogar bola com os amigos.'
        ]);

        echo $this->Flash->render();

        echo $this->Form->button(__('Adicionar'));
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
    </aside>
</div>