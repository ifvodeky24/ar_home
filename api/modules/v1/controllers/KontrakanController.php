<?php
namespace app\api\modules\v1\controllers;

use Yii;
use app\models\Kontrakan;
use yii\rest\Controller;
use yii\web\Response;


class KontrakanController extends Controller
{

  /*
	GET
	Fungsi untuk mendapatkan semua data kontrakan
	*/
	public function actionGetAll(){
		Yii::$app->response->format = Response::FORMAT_JSON;

		$response = null;

		if (Yii::$app->request->isGet){

			// select * from tb_kontrakan
			$kontrakan = Kontrakan::find()->all();

			$response['master'] = $kontrakan;
		}

		return $response;
	}

  /*
	GET
	Fungsi untuk mendapatkan data kontrakan filter by id_kontrakan
	*/
  public function actionById ($id_kontrakan){
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isGet) {
      // code...
      $kontrakan = Kontrakan::find()
                      ->where(['id_kos' => $id_kontrakan])
                      ->all();

                      $response['master'] = $kontrakan;
    }

    return $response;
  }

	/*
	GET
	Fungsi untuk mendapatkan semua data-data kontrakan yang terdekat dari lokasi saat ini
	*/
	public function actionGetAllTerdekat($myLat, $myLng, $jarak){
		Yii::$app->response->format = Response::FORMAT_JSON;

		$response = null;

		if (Yii::$app->request->isGet){

			$sql = "SELECT dt_kontrakan.id_kontrakan, dt_kontrakan.nama, dt_kontrakan.deskripsi, dt_kontrakan.foto, dt_kontrakan.waktu_post, dt_kontrakan.id_pemilik, dt_kontrakan.latitude, dt_kontrakan.longitude, dt_kontrakan.altitude, dt_kontrakan.harga, dt_kontrakan.rating, dt_kontrakan.status,
                    (((acos(sin(('$myLat'*pi()/180))
                    * sin((`latitude`*pi()/180))+cos(('$myLat'*pi()/180))
                    * cos((`latitude`*pi()/180)) * cos((('$myLng'-`longitude`)
                    * pi()/180))))*180/pi())*60*1.1515*1.609344)
                    as jarak FROM `dt_kontrakan`
                    HAVING jarak <= $jarak AND dt_kontrakan.status = 'tersedia'
                    ORDER BY jarak ASC";

			$response['master'] = Yii::$app->db->createCommand($sql)->queryAll();
		}

		return $response;
	}

	/*
	GET
	Fungsi untuk mendapatkan data kontrakan di filter by id_kontrakan
	*/
  public function actionById ($id_kontrakan){
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isGet) {
      // code...
      $kos = Kos::find()
                      ->where(['id_kontrakan' => $id_kontrakan])
                      ->all();

                      $response['master'] = $kontrakan;
    }

    return $response;
  }

  /*
  CREATE
  Fungsi untuk menambah kontrakan terbaru
  */
  public function actionTambahKontrakan(){
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->Post();
      // code...
      $nama = $data['nama'];
      $deskripsi = $data['deskripsi'];
      $foto = $data['foto'];
      $waktu_post = $data['waktu_post'];
      $id_pemilik = $data['id_pemilik'];
      $latitude = $data['latitude'];
      $longitude = $data['longitude'];
      $altitude = $data['altitude'];
      $harga = $data['harga'];
      $rating = $data['rating'];
      $status = $data['status'];

      // lakukan insert data
      $kontrakan = new Kontrakan();
      $kontrakan->nama= $nama;
      $kontrakan->deskripsi= $deskripsi;
      $kontrakan->foto= $foto;
      $kontrakan->waktu_post= $waktu_post;
      $kontrakan->id_pemilik= $id_pemilik;
      $kontrakan->latitude= $latitude;
      $kontrakan->longitude= $longitude;
      $kontrakan->altitude= $altitude;
      $kontrakan->harga= $harga;
      $kontrakan->rating= $rating;
      $kontrakan->status= $status;

      if($kontrakan->save(false)){
        //jika data berhasil disimpan
        $response['code'] = 1;
				$response['message'] = "Tambah Kontrakan berhasil";
				$response['data'] = $kontrakan;
      }else{
        $response['code'] = 0;
				$response['message'] = "Tambah Kontrakan gagal";
				$response['data'] = null;
      }
    }
    	return $response;
  }

  /*
  UPDATE
  Fungsi untuk update data kontrakan yang sudah ada
  */
  public function actionUpdateKontrakan() {
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->Post();

      $id_kontrakan= $data['id_kontrakan'];
      $nama = $data['nama'];
      $deskripsi = $data['deskripsi'];
      $foto = $data['foto'];
      $waktu_post = $data['waktu_post'];
      $id_pemilik = $data['id_pemilik'];
      $latitude = $data['latitude'];
      $longitude = $data['longitude'];
      $altitude = $data['altitude'];
      $harga = $data['harga'];
      $rating = $data['rating'];
      $status = $data['status'];

      $kontrakan = Kontrakan::find()
                      ->where(['id_kontrakan' => $id_kontrakan])
                      ->one();

      if (isset($kontrakan)) {
        // code...
        $kontrakan->nama= $nama;
        $kontrakan->deskripsi= $deskripsi;
        $kontrakan->foto= $foto;
        $kontrakan->waktu_post= $waktu_post;
        $kontrakan->id_pemilik= $id_pemilik;
        $kontrakan->latitude= $latitude;
        $kontrakan->longitude= $longitude;
        $kontrakan->altitude= $altitude;
        $kontrakan->harga= $harga;
        $kontrakan->rating= $rating;
        $kontrakan->status= $status;

        if ($kontrakan->update()) {
          // jika data berhasil diupdate
          $response['code'] = 1;
  				$response['message'] = "Update berhasil";
  				$response['data'] = $kontrakan;
        }else {
          $response['code'] = 0;
  				$response['message'] = "Update gagal";
  				$response['data'] = null;
        }
      }else {
        $response['code'] = 0;
        $response['message'] = "Data tidak ditemukan";
        $response['data'] = null;
      }
    }
    return $response;

  }

  /*
  DELETE
  Fungsi untuk menghapus kontrakan
  */
    public function actionDelete(){
      Yii::$app->response->format = Response::FORMAT_JSON;

      $response = null;

      if (Yii::$app->request->isPost) {
        $data = Yii::$app->request->Post();

        $id_kontrakan= $data['id_kontrakan'];

        $kontrakan = Kontrakan::find()
                        ->where(['id_kontrakan' => $id_kontrakan])
                        ->one();

                        if (isset($kontrakan)) {
                          if($kontrakan->delete()){
                            //jika data berhasil dihapus
                            $response['code'] = 1;
                            $response['message'] = "Delete berhasil";
                          }else {
                            // code...
                            $response['code'] = 0;
                            $response['message'] = "Delete Gagal";
                          }

                        }else {
                            $response['code'] = 0;
                            $response['message'] = "Data tidak ditemukan";
                          }

        }
        return $response;
      }

}
