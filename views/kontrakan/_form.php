<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kontrakan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <?php $form = ActiveForm::begin(); ?>
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <center><h3 class="box-title">Form Tambah Kontrakan</h3><center>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form">
        <div class="box-body">
          <div class="form-group">
            <?= $form->field($model, 'nama')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Nama Kontrakan','class'=>'form-control']) ?>
            <?= $form->field($model, 'deskripsi')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Deskripsi Kontrakan','class'=>'form-control']) ?>
            <?= $form->field($model, 'foto')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Foto Kontrakan','class'=>'form-control']) ?>
            <?= $form->field($model, 'waktu_post')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Waktu Post','class'=>'form-control']) ?>
            <?= $form->field($model, 'id_pemilik')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Id Pemilik','class'=>'form-control']) ?>
            <?= $form->field($model, 'latitude')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Latitude','class'=>'form-control']) ?>
            <?= $form->field($model, 'longitude')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Longitude','class'=>'form-control']) ?>
            <?= $form->field($model, 'altitude')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Altitude','class'=>'form-control']) ?>
            <?= $form->field($model, 'harga')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Harga','class'=>'form-control']) ?>
            <?= $form->field($model, 'rating')->textInput(['maxlength' => true,'placeholder'=>'Masukkan Rating','class'=>'form-control']) ?>
            <?= $form->field($model, 'status')->dropDownList([ 'tersedia' => 'Tersedia', 'tidak tersedia' => 'Tidak tersedia', 'tidak aktif' => 'Tidak aktif', ], ['prompt' => '']) ?>
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  				<button type="reset" class="btn btn-inverse">Reset</button>
        </div>
      </form>
    </div>
    <!-- /.box -->
    <?php ActiveForm::end(); ?>
  </div>
  <!--/.col (left) -->
  <!-- right column -->

  <!--/.col (right) -->
</div>
