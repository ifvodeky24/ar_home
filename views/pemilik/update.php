<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pemilik */

$this->title = 'Update Pemilik: ' . $model->id_pemilik;
$this->params['breadcrumbs'][] = ['label' => 'Pemiliks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pemilik, 'url' => ['view', 'id' => $model->id_pemilik]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pemilik-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
