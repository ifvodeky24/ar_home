<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pengguna".
 *
 * @property int $id_pengguna
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $nama_lengkap
 * @property string $alamat
 * @property string $foto
 * @property string $no_handphone
 * @property string $status_memesan
 *
 * @property PemesananKontrakan[] $PemesananKontrakan
 * @property PemesananKos[] $PemesananKos
 */
class Pengguna extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_pengguna';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'nama_lengkap', 'alamat', 'foto', 'no_handphone'], 'required'],
            [['status_memesan'], 'string'],
            [['username', 'email', 'alamat', 'foto'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 255],
            [['nama_lengkap'], 'string', 'max' => 40],
            [['no_handphone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pengguna' => 'Id Pengguna',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'nama_lengkap' => 'Nama Lengkap',
            'alamat' => 'Alamat',
            'foto' => 'Foto',
            'no_handphone' => 'No Handphone',
            'status_memesan' => 'Status Memesan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPemesananKontrakan()
    {
        return $this->hasMany(PemesananKontrakan::className(), ['id_pengguna' => 'id_pengguna']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPemesananKos()
    {
        return $this->hasMany(PemesananKos::className(), ['id_pengguna' => 'id_pengguna']);
    }
}
