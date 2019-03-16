<?php
namespace app\api\modules\v1\controllers;

use Yii;
use app\models\PemesananKontrakan;
use app\models\Kontrakan;
use yii\rest\Controller;
use yii\web\Response;
use app\models\Pengguna;


class PemesananKontrakanController extends Controller
{

  /*
	GET
	Fungsi untuk mendapatkan semua data pesanan kontrakan
	*/
	public function actionGetAll(){
		Yii::$app->response->format = Response::FORMAT_JSON;

		$response = null;

		if (Yii::$app->request->isGet){

			// select * from tb_pemesanan_kontrakan
			$pemesanan_kontrakan = PemesananKontrakan::find()->all();

			$response['master'] = $pemesanan_kontrakan;
		}
		return $response;
	}

  /*
	GET
	Fungsi untuk mendapatkan data pemesanan kontrakan filter by id_pemesanan_kontrakan
	*/
  public function actionById ($id_pemesanan_kontrakan){
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isGet) {
      // code...
      $pemesanan_kontrakan = PemesananKontrakan::find()
                      ->where(['id_pemesanan_kontrakan' => $id_pemesanan_kontrakan])
                      ->one();

                      $response['master'] = $pemesanan_kontrakan;
    }
    return $response;
  }

	/*
	GET
	Fungsi untuk mendapatkan data pemesanan kontrakan filter by id_pemilik dan status
	*/
  public function actionGetAllByPemilik($id_pemilik){
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isGet) {
      // code...
      $sql = "SELECT tb_pemesanan_kontrakan.id_pemesanan_kontrakan, tb_pemesanan_kontrakan.status, tb_pemesanan_kontrakan.review, tb_pemesanan_kontrakan.rating,
							dt_kontrakan.nama as nama_kontrakan, dt_kontrakan.foto as foto_kontrakan, dt_kontrakan.harga,
							tb_pemilik.nama_lengkap as nama_lengkap_pemilik, tb_pemilik.no_handphone as no_handphone_pemilik,
							tb_pengguna.id_pengguna, tb_pengguna.nama_lengkap as nama_lengkap_pengguna,
							tb_pengguna.no_handphone as no_handphone_pengguna, tb_pengguna.foto as foto_pengguna
							FROM tb_pemesanan_kontrakan INNER JOIN dt_kontrakan, tb_pemilik, tb_pengguna
							WHERE tb_pemesanan_kontrakan.id_kontrakan = dt_kontrakan.id_kontrakan
							AND dt_kontrakan.id_pemilik = tb_pemilik.id_pemilik
							AND tb_pemilik.id_pemilik = '$id_pemilik'
           
							AND tb_pemesanan_kontrakan.id_pengguna = tb_pengguna.id_pengguna

							GROUP BY tb_pemesanan_kontrakan.id_pemesanan_kontrakan";

              $response['master'] = Yii::$app->db->createCommand($sql)->queryAll();;
    }
    return $response;
  }

	/*
	GET
	Fungsi untuk melihat history data pemesanan kontrakan filter by id_pengguna dan status
	*/
  public function actionGetAllByPengguna($id_pengguna){
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isGet) {
      // code...
      $sql = "SELECT tb_pemesanan_kontrakan.id_pemesanan_kontrakan, tb_pemesanan_kontrakan.status, tb_pemesanan_kontrakan.review, tb_pemesanan_kontrakan.rating,
							dt_kontrakan.nama as nama_kontrakan, dt_kontrakan.foto as foto_kontrakan, dt_kontrakan.harga,
							tb_pemilik.nama_lengkap as nama_lengkap_pemilik, tb_pemilik.no_handphone as no_handphone_pemilik,
							tb_pengguna.id_pengguna, tb_pengguna.nama_lengkap as nama_lengkap_pengguna,
							tb_pengguna.no_handphone as no_handphone_pengguna, tb_pengguna.foto as foto_pengguna
							FROM tb_pemesanan_kontrakan INNER JOIN dt_kontrakan, tb_pemilik, tb_pengguna
							WHERE tb_pemesanan_kontrakan.id_kontrakan = dt_kontrakan.id_kontrakan
							AND tb_pemesanan_kontrakan.id_pengguna = tb_pengguna.id_pengguna
							AND tb_pengguna.id_pengguna = '$id_pengguna' 

							GROUP BY tb_pemesanan_kontrakan.id_pemesanan_kontrakan";

              $response['master'] = Yii::$app->db->createCommand($sql)->queryAll();;
    }
    return $response;
  }

  /*
  CREATE
  Fungsi untuk menambah pemesanan kontrakan / booking
  */
  public function actionBookingKontrakan(){
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->Post();
      // code...
      $id_pengguna = $data['id_pengguna'];
      $id_kontrakan = $data['id_kontrakan'];
      // $status = $data['status'];
      // $review = $data['review'];
      // $rating = $data['rating'];

      //lakukan insert data
      $pemesanan_kontrakan = new PemesananKontrakan();
      $pemesanan_kontrakan->id_pengguna= $id_pengguna;
      $pemesanan_kontrakan->id_kontrakan= $id_kontrakan;
      $pemesanan_kontrakan->status= "booking";
      $pemesanan_kontrakan->review= "";
      $pemesanan_kontrakan->rating= 0;

      $pengguna = Pengguna::find()
      ->where(['id_pengguna' => $id_pengguna] )
      ->one();

	      if ($pengguna->status_memesan == 0) {
	      	# code...
	      	  if($pemesanan_kontrakan->save(false)){

	      		$kontrakan = Kontrakan::find()
							->where(['id_kontrakan' => $pemesanan_kontrakan->id_kontrakan])
							->one();

				$pengguna = Pengguna::find()
							->where(['id_pengguna' =>  $pemesanan_kontrakan->id_pengguna])
							->one();

				$pengguna->status_memesan = 1;

				$kontrakan->status = 'tidak tersedia';

						// jika data berhasil diupdate
						if ($kontrakan->save(false) && $pengguna->save(false)) {
							$response['code'] = 1;
							$response['message'] = "Pemesanan Kontrakan Berhasil dibooking";
							$response['data'] = $pemesanan_kontrakan;
						}else {
							$response['code'] = 0;
							$response['message'] = "Status kontrakan dan pengguna gagal update";
							$response['data'] = null;
						}
	       
	      }else{
	        $response['code'] = 0;
					$response['message'] = "Pemesanan Kontrakan Gagal ditambah";
					$response['data'] = null;
	      }
      }else{
      	$response['code'] = 0;
					$response['message'] = "Anda masih dalam status memesan";
					$response['data'] = null;
	      }
      }
    	return $response;
  }

  /*
  UPDATE
  Fungsi untuk update data kontrakan dari booking menjadi dalam pemesanan
  */
  public function actionUpdatePemesananKontrakanDalamPemesanan() {
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->Post();

      $id_pemesanan_kontrakan= $data['id_pemesanan_kontrakan'];
      // $status = $data['status'];

      $pemesanan_kontrakan = PemesananKontrakan::find()
                      ->where(['id_pemesanan_kontrakan' => $id_pemesanan_kontrakan])
                      ->one();

	      if (isset($pemesanan_kontrakan)) {
	        // code...
	        $pemesanan_kontrakan->status= "dalam pemesanan";

	        if ($pemesanan_kontrakan->update(false)) {
						$response['code'] = 1;
							$response['message'] = "Status  pemesanan kontrakan berhasil diupdate menjadi dalam pemesanan";
							$response['data'] = $pemesanan_kontrakan;

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
  UPDATE
  Fungsi untuk update menambahkan rating dan review kontrakan
  */

  public function actionUpdateRatingReviewKontrakan() {
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->Post();

      $id_pemesanan_kontrakan= $data['id_pemesanan_kontrakan'];
	  // $status = $data['status'];
      $review = $data['review'];
      $rating = $data['rating'];

      $pemesanan_kontrakan = PemesananKontrakan::find()
                      ->where(['id_pemesanan_kontrakan' => $id_pemesanan_kontrakan])
                      ->one();

		      if (isset($pemesanan_kontrakan)) {
		        // code...
		        $pemesanan_kontrakan->review= $review;
		        $pemesanan_kontrakan->rating= $rating;

		        if ($pemesanan_kontrakan->update(false)) {
							$response['code'] = 1;
		                    $response['message'] = "Rating dan Review Kontrakan berhasil ditambah";
		                    $response['data'] = $pemesanan_kontrakan;

		        }else {
		          $response['code'] = 0;
		  				$response['message'] = "Rating dan Review Kontrakan gagal ditambah";
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
  UPDATE
  Fungsi untuk update data kontrakan dari dalam pemesanan menjadi selesai
  */
  public function actionUpdatePemesananKontrakanSelesai() {
    Yii::$app->response->format = Response::FORMAT_JSON;

    $response = null;

    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->Post();

      $id_pemesanan_kontrakan= $data['id_pemesanan_kontrakan'];
      // $status = $data['status'];
	 
      $pemesanan_kontrakan = PemesananKontrakan::find()
                      ->where(['id_pemesanan_kontrakan' => $id_pemesanan_kontrakan])
                      ->one();

      if (isset($pemesanan_kontrakan)) {
        // code...
        $pemesanan_kontrakan->status= "selesai";

        $pengguna = Pengguna::find()
                        ->where(['id_pengguna'=> $pemesanan_kontrakan->id_pengguna])
                        ->one();

        $pengguna->status_memesan = 0;

        $kontrakan = Kontrakan::find()
						->where(['id_kontrakan' => $pemesanan_kontrakan->id_kontrakan])
						->one();

		$kontrakan->status = 'tersedia';
		
				if ($pemesanan_kontrakan->update(false)) {
					
					// jika data berhasil diupdate
					if ($kontrakan->update(false) && $pengguna->update(false)) {
						$response['code'] = 1;
						$response['message'] = "Status  pemesanan kontrakan berhasil diupdate menjadi selesai";
						$response['data'] = $pemesanan_kontrakan;
					}else {
						$response['code'] = 0;
						$response['message'] = "Status  pemesanan kontrakan gagal diupdate menjadi selesai";
						$response['data'] = null;
					}

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
}
