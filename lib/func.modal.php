<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("

function FormModal($idna="",$Kalimat="",$Eusi=""){
	return "
	<style>
	.modal-dialog{
		padding-top: 5px;
		border-radius:0;
	}
	.modal-content{
		border-radius: 0;
		border: 5px solid #1a6495;
	}

	.modal-header{
		padding-bottom: 15px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;

	.modal-footer{
		padding-bottom: 5px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;
	}
	</style>

	<div id='$idna' class='modal fade' tabindex='-1' aria-hidden='true' style='display: none;'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><i class=' fa fa-times'></i></button>
					<h4 class='white bigger'>$Kalimat</h4>
				</div>

				<div class='modal-body no-padding'>
					<div class='row'>
						<div class='col-xs-12'>$Eusi</div>
					</div>
				</div>

				<div class='modal-footer'>
					<span class='pull-right'><em><strong class='txt-color-red'>by Abdul Madjid, M.Pd. (Developer)</strong></em></span>
				</div>
			</div>
		</div>
	</div>";
}

function FormModalAksi($IDna="",$Judul="",$Eusi="",$namasubmit="",$judulsubmit){
	return "
	<style>
	.modal-dialog{
		padding-top: 5px;
		border-radius:0;
	}
	.modal-content{
		border-radius: 0;
		border: 5px solid #1a6495;
	}

	.modal-header{
		padding-bottom: 15px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;

	.modal-footer{
		padding-bottom: 5px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;
	}
	</style>

	<div id='$IDna' class='modal fade' tabindex='-1' aria-hidden='true' style='display: none;'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><i class=' fa fa-times'></i></button>
					<h4 class='white bigger'>$Judul</h4>
				</div>

				<div class='modal-body'>
					<div class='row'>
						<div class='col-xs-12'>$Eusi</div>
					</div>
				</div>

				<div class='modal-footer padding-10'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
					<input type='submit' class='btn btn-primary' name='$namasubmit' value='$judulsubmit'>
				</div></form>
			</div>
		</div>
	</div>";
}

function FormModalEdit($ModalUkuran,$ModalID,$ModalJudul,$ModalAksi,$ModalForm,$ModalIDBody,$ModalNSubmit,$ModalJSubmit){
	if($ModalUkuran=="lebar"){$Ukuran="lg";}else
	if($ModalUkuran=="sedang"){$Ukuran="md";}else
	if($ModalUkuran=="sempit"){$Ukuran="sm";}

	return "
	<style>
	.modal-dialog{
		padding-top: 5px;
		border-radius:0;
	}
	.modal-content{
		border-radius: 0;
		border: 5px solid #1a6495;
	}

	.modal-header{
		padding-bottom: 15px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;

	.modal-footer{
		padding-bottom: 5px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;
	}
	</style>

	<div id='$ModalID' class='modal fade' tabindex='-1' aria-hidden='true' style='display: none;'>
		<div class='modal-dialog modal-$Ukuran'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><i class=' fa fa-times'></i></button>
					<h4 class='white bigger'>$ModalJudul</h4>
				</div>
					<div class='modal-body'>
						<form method='post' action='$ModalAksi' class='$ModalForm'>
						<div class='row'>
							<div class='col-xs-12' id='$ModalIDBody'></div>
						</div>
					</div>
					<div class='modal-footer padding-10'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
						<input type='submit' class='btn btn-primary' name='$ModalNSubmit' value='$ModalJSubmit'>
					</div>
				</form>
			</div>
		</div>
	</div>";
}

function FormModalAksi2($IDna="",$Judul="",$Eusi="",$namasubmit="",$judulsubmit){
	return "
	<style>
	.modal-dialog{
		padding-top: 5px;
		border-radius:0;
	}
	.modal-content{
		border-radius: 0;
		border: 5px solid #1a6495;
	}

	.modal-header{
		padding-bottom: 15px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;

	.modal-footer{
		padding-bottom: 5px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;
	}
	</style>

	<div id='$IDna' class='modal fade' tabindex='-1' aria-hidden='true' style='display: none;'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><i class=' fa fa-times'></i></button>
					<h4 class='white bigger'>$Judul</h4>
				</div>

				<div class='modal-body'>
					<div class='row'>
						<div class='col-xs-12'>$Eusi</div>
					</div>
				</div>

				<div class='modal-footer padding-10'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
					<input type='submit' class='btn btn-primary' name='$namasubmit' value='$judulsubmit'>
				</div></form>
			</div>
		</div>
	</div>";
}

function FormModalAksiLebar($IDna="",$Judul="",$Eusi=""){
	return "
	<style>
	.modal-dialog{
		padding-top: 5px;
		border-radius:0;
	}
	.modal-content{
		border-radius: 0;
		border: 5px solid #1a6495;
	}

	.modal-header{
		padding-bottom: 15px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;

	.modal-footer{
		padding-bottom: 5px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;
	}
	</style>

	<div id='$IDna' class='modal fade' tabindex='-1' aria-hidden='true' style='display: none;'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><i class=' fa fa-times'></i></button>
					<h4 class='white bigger'>$Judul</h4>
				</div>

				<div class='modal-body'>
					<div class='row'>
						<div class='col-xs-12'>$Eusi</div>
					</div>
				</div>

				<div class='modal-footer padding-10'>
					<a href='?page=kurikulum-datakbm-nilai-kelas' class='btn btn-primary btn-sm pull-right' onclick=\"printContent('cetakDok')\" data-dismiss='modal'><i class='fa fa-print fa-lg'></i> Cetak Dokumen</a>
				</div>
			</div>
		</div>
	</div>";
}

function FormModalInfo($IDna="",$Judul="",$Eusi=""){
	return "
	<style>
	.modal-dialog{
		padding-top: 5px;
		border-radius:0;
	}
	.modal-content{
		border-radius: 0;
		border: 5px solid #1a6495;
	}

	.modal-header{
		padding-bottom: 15px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;

	.modal-footer{
		padding-bottom: 5px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;
	}
	</style>

	<div id='$IDna' class='modal fade' tabindex='-1' aria-hidden='true' style='display: none;'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><i class=' fa fa-times'></i></button>
					<h4 class='white bigger'>$Judul</h4>
				</div>

				<div class='modal-body'>
					<div class='row'>
						<div class='col-xs-12'>$Eusi</div>
					</div>
				</div>

				<div class='modal-footer padding-10'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>
				</div></form>
			</div>
		</div>
	</div>";
}

function FormModalDetail($IDna="",$Judul="",$IDBody=""){
	return "
	<style>
	.modal-dialog{
		padding-top: 5px;
		border-radius:0;
	}
	.modal-content{
		border-radius: 0;
		border: 5px solid #1a6495;
	}

	.modal-header{
		padding-bottom: 15px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;

	.modal-footer{
		padding-bottom: 5px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;
	}
	</style>

	<div id='$IDna' class='modal fade' tabindex='-1' aria-hidden='true' style='display: none;'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><i class=' fa fa-times'></i></button>
					<h4 class='white bigger'>$Judul</h4>
				</div>

				<div class='modal-body'>
					<div class='row'>
						<div class='col-xs-12' id='$IDBody'></div>
					</div>
				</div>

				<div class='modal-footer padding-10'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>
				</div></form>
			</div>
		</div>
	</div>";
}


function FormModalDetail2($ModalUkuran,$IDna="",$Judul="",$IDBody=""){

	if($ModalUkuran=="lebar"){$Ukuran="lg";}else
	if($ModalUkuran=="sedang"){$Ukuran="md";}else
	if($ModalUkuran=="sempit"){$Ukuran="sm";}

	return "
	<style>
	.modal-dialog{
		padding-top: 5px;
		border-radius:0;
	}
	.modal-content{
		border-radius: 0;
		border: 5px solid #1a6495;
	}

	.modal-header{
		padding-bottom: 15px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;

	.modal-footer{
		padding-bottom: 5px;
		padding-top: 5px;
		background-color: #1a6495;
		color:#fff;
	}
	</style>

	<div id='$IDna' class='modal fade' tabindex='-1' aria-hidden='true' style='display: none;'>
		<div class='modal-dialog modal-$Ukuran'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><i class=' fa fa-times'></i></button>
					<h4 class='white bigger'>$Judul</h4>
				</div>

				<div class='modal-body'>
					<div class='row'>
						<div class='col-xs-12' id='$IDBody'></div>
					</div>
				</div>

				<div class='modal-footer padding-10'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>
				</div></form>
			</div>
		</div>
	</div>";
}

//");
?>