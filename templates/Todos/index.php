<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Todo> $todos
 */
?>

<?= $this->Html->css(['home', 'paginator']) ?>


<?php
echo $this->Form->create(null, ['type' => 'get', 'class' => 'search-todos']);
echo $this->Form->control('search', [
    'value' => $this->request->getQuery('search'),
    'label' => false,
    'placeholder' => 'Procure uma tarefa...',
]);
echo $this->Form->button(
    $this->Html->image('lupa.svg', ['alt' => 'Imagem de uma lupa']),
    [
        'escapeTitle' => false,
        'title' => 'Pesquisar tarefa'
    ]
);
echo $this->Form->end();
?>

<?= $this->Flash->render() ?>

<div class="main-content">
    <div class="main-header">
        <h1><?= __('Sua lista de tarefas') ?></h1>
        <?= $this->Html->link(__('Nova tarefa'), ['action' => 'add'], ['class' => 'newTodoButton']) ?>
    </div>


    <?php if (empty($todos)) : ?>
        <div class="todos-container empty">
            <div>
                <?= $this->Html->image('icon-notodo.svg', ['alt' => 'Ícone informando que não tem tarefas',]) ?>
                <p>
                    Não encontramos nenhuma tarefa.<br>
                    <?= $this->Html->link('Desaja adicionar uma nova?', ['action' => 'add']) ?>
                </p>
            </div>
        </div>
    <?php else : ?>
        <div class="sort">
            <h3>Ordenar por: </h3>
            <?= $this->Paginator->sort('title', 'Título') ?>
            <?= $this->Paginator->sort('modified', 'Última modificação') ?>
        </div>

        <ul class="todos-container">
            <?php foreach ($todos as $todo) : ?>
                <li class="todo-card">
                    <a title="Abrir tarefa" href=<?= $this->Url->build(['action' => 'view', $todo->slug]) ?>>
                        <h2 class="todo-title">
                            <?= $this->Text->truncate($todo->title, 90, [
                                'ellipsis' => '...',
                                'exact' => false
                            ]); ?>
                        </h2>

                        <p class="todo-body">
                            <?= $this->Text->truncate($todo->body, 220, [
                                'ellipsis' => '...',
                                'exact' => false
                            ]); ?>
                        </p>

                        <p class="todo-dateadd">
                            <?= $todo->modified->i18nFormat('dd-MM-yyyy | HH:mm', 'America/Sao_Paulo'); ?>
                        </p>
                    </a>

                    <div class="todo-config">
                        <?= $this->Html->image('icon-edit-gray.svg', [
                            'alt' => 'Editar tarefa',
                            'title' => 'Editar tarefa',
                            'url' => ['action' => 'edit', $todo->slug]
                        ]) ?>

                        <?= $this->Form->postLink(
                            $this->Html->image('icon-delete-gray.svg', ['alt' => 'Deletar tarefa', 'title' => 'Deletar tarefa']),
                            ['action' => 'delete', $todo->slug],
                            [
                                'confirm' => 'Você tem certeza que deseja apagar esta tarefa?',
                                'escape' => false // isto é necessário para que o cake não imprima o código em forma de texto
                            ]
                        ); ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="paginator">
            <div>
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('Primeiro')) ?>
                    <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                    <?= $this->Paginator->numbers(['modulus' => 4]) ?>
                    <?= $this->Paginator->next(__('Próximo') . ' >') ?>
                    <?= $this->Paginator->last(__('Último') . ' >>') ?>
                </ul>
            </div>
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}')) ?></p>
        </div>
    <?php endif; ?>
</div>