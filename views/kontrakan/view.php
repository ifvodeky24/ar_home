<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kontrakan */

$this->title = $model->id_kontrakan;
$this->params['breadcrumbs'][] = ['label' => 'Kontrakans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kontrakan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_kontrakan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_kontrakan], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_kontrakan',
            'nama',
            'deskripsi',
            'foto',
            'waktu_post',
            'pemilik.nama_lengkap' ,
            'pemilik.no_handphone',
            'latitude',
            'longitude',
            'altitude',
            'harga',
            'rating',
            'status',
        ],
    ]) ?>

</div>