<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kontrakan */

$this->title = 'Tambah Kontrakan';
$this->params['breadcrumbs'][] = ['label' => 'Kontrakan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kontrakan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
