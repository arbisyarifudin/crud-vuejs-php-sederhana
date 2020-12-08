<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Implementasi VUE JS dengan PHP untuk CRUD</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>

	<div id="app">

		<div class="container mt-3">
			<div class="row justify-content-between align-items-center">
				<div class="col-lg-6">
					<h1>Data Produk</h1>
				</div>
				<div class="col-lg-4">
					<input type="text" class="form-control" v-model="cari" placeholder="Cari produk">
				</div>
			</div>
			<hr>

			<!--  jika pesan.teks tidak NULL tampilkan ELEMENT DIV dibawah, yang berisi pesan.teks -->
			<div v-if="pesan.teks !== null" :class="'alert alert-dismissible fade show alert-'+pesan.tipe">
				{{pesan.teks}}
				<button type="button" class="close" aria-label="Close" @click="pesan.teks = null">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<!-- data tabel produk -->
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th style="width: 100px;">Foto</th>
						<th>Nama Produk</th>
						<th>Harga</th>
						<th>Berat</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(p, index) in produk">
						<td>{{index+1}}</td>
						<td>
							<img :src="`gambar/${p.gambar}`" class="img-fluid" width="100" alt="foto">
						</td>
						<td>{{p.nama}}</td>
						<td>{{p.harga}}</td>
						<td>{{p.berat}}</td>
						<td>
							<!-- pada saat tombol hapus ini di klik jalankan fungsi hapus_produk dengan melemparkan id produk nya -->
							<button type="button" class="btn btn-danger btn-sm" @click="hapus_produk(p.id)">Hapus</button>
							<!-- pada saat tombol ubah ini di klik, buka modal ubah, lalu jalankan fungsi isi_form dengen melemparkan objek p (produk) untuk mengisi data form di vue js menjadi data produk yang di klik -->
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-ubah" @click="isi_form(p)">Ubah</button>
							<!-- modal detail produk -->
							<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-detail" @click="isi_form(p)">Detail</button>
						</td>
					</tr>
					<!-- jika data produk kosong, isi table dengan pesan -->
					<tr v-if="produk.length == 0">
						<td colspan="5" class="text-center">Data produk kosong masih kosong.</td>
					</tr>
					<!-- jika loading == true, tampilkan pesan memuat -->
					<tr v-if="loading==true">
						<td colspan="5" class="text-center text-info">Memuat data...</td>
					</tr>
				</tbody>
			</table>

			<button type="button" data-toggle="modal" data-target="#modal-tambah" class="btn btn-primary" @click="resetForm">Tambah Data</button>
		</div>

		<!-- MODAL TAMBAH PRODUK -->
		<div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form method="POST" action="" enctype="multipart/form-data" @submit.prevent="tambah_produk">
						<div class="modal-header">
							<h5 class="modal-title">Tambah Produk</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Nama Produk</label>
								<input type="text" class="form-control" v-model="form.nama" required>
							</div>
							<div class="form-group">
								<label>Harga Produk</label>
								<input type="number" class="form-control" v-model="form.harga" required>
							</div>
							<div class="form-group">
								<label>Berat Produk</label>
								<input type="number" class="form-control" v-model="form.berat" required>
							</div>
							<div class="form-group">
								<label>Deskripsi Produk</label>
								<textarea class="form-control" v-model="form.deskripsi" required></textarea>
							</div>
							<div class="form-group">
								<label>Foto Produk</label>
								<!-- saat input ini di ubah/change, jalankan funsgi handleUpload untuk menangani isi file nya -->
								<input type="file" ref="file" @change="handleUpload" class="form-control" required>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- MODAL UBAH PRODUK -->
		<div class="modal fade" tabindex="-1" role="dialog" id="modal-ubah">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form method="POST" action="" enctype="multipart/form-data" @submit.prevent="ubah_produk">
						<div class="modal-header">
							<h5 class="modal-title">Ubah Produk</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Nama Produk</label>
								<input type="text" class="form-control" v-model="form.nama" required>
							</div>
							<div class="form-group">
								<label>Harga Produk</label>
								<input type="number" class="form-control" v-model="form.harga" required>
							</div>
							<div class="form-group">
								<label>Berat Produk</label>
								<input type="number" class="form-control" v-model="form.berat" required>
							</div>
							<div class="form-group">
								<label>Deskripsi Produk</label>
								<textarea class="form-control" v-model="form.deskripsi" required></textarea>
							</div>
							<div class="form-group">
								<img width="150" class="img-fluid" :src="`gambar/${form.gambar}`" alt="foto produk">
							</div>
							<div class="form-group">
								<label>Foto Produk</label>
								<input type="file" ref="file" @change="handleUpload" class="form-control">
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- MODAL DETAIL PRODUK -->
		<div class="modal fade" tabindex="-1" role="dialog" id="modal-detail">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Detail Produk</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
								<img class="img-fluid" :src="`gambar/${form.gambar}`" alt="foto produk">
							</div>
							<div class="col-md-8">
								<h6 class="h3">{{form.nama}}</h6>
								<div class="content">
									<h6 style="font-weight: normal;">Rp. {{form.harga}} - {{form.berat}} <i>gram</i></h6>
									<hr>
									{{form.deskripsi}}
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>

	</div>

	<footer>
		<div class="container text-center mt-5">
			<p class="small">Implementasi VUE JS dengan PHP untuk CRUD</p>
			<p><a target="_blank" href="http://github.com/arbisyarifudin" title="Lihat author" style="color: #333">Arbi Syarifudin</a> &copy; <?= date('Y') ?></p>
		</div>
	</footer>


	<!-- AXIOS -->
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<!-- VUE JS -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<!-- BOOTSTRAP JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


	<!-- SCRIPT KITA -->
	<script src=" script.js"></script>

</body>

</html>