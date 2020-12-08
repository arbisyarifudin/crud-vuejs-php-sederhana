var vue = new Vue({
	el: '#app',
	data: {
		judul: 'Data Produk',
		url: 'http://localhost/trainit/vue/crud.php',
		produk: [],
		cari: '',
		loading: true,
		pesan: {
			teks: null,
			tipe: null,
		},
		form: {
			nama: null,
			harga: null,
			berat: null,
			deskripsi: null,
			file: null, // menyimpan file upload di modal tambah
			gambar: null, // menyimpan nama gambar untuk modal detail & edit
			id: null,
		}
	},
	created() {
		// ketika web baru di load, langsung jalankan fungsi ambil_produk untuk mengisi array produk diatas yang akan menampilkan data produk di table produk
		this.ambil_produk();
	},
	methods: {
		ambil_produk() {

			// nyalakan loading
			this.loading = true;

			// ambil data dari API URL dengan parameter aksi == tampil_produk
			axios.get(this.url, {
				params: { aksi: 'tampil_produk' }
			})
				.then(respon => {
					console.log(respon)

					// ambil data dari respon axios
					let data = respon.data

					// masukan data ke array produk
					this.produk = data;

					// matikan loading
					this.loading = false;

				})
				.catch(error => {
					// tangkap error jika ada
					console.log(error)
				})
		},
		handleUpload() {
			this.form.file = this.$refs.file.files[0];
		},
		tambah_produk() {

			// disable semua tombol submit
			$("button[type=submit]").prop('disabled', true);

			// siapkan data tambah dari obj formData
			let dataTambah = new FormData();

			// // siapkan data tambah
			// let data_tambah = {
			// 	aksi: 'tambah_produk',
			// 	data: {
			// 		nama: this.form.nama,
			// 		harga: this.form.harga,
			// 		berat: this.form.berat,
			// 		deskripsi: this.form.deskripsi,
			// 	},
			// 	file: this.form.file
			// }

			dataTambah.append('aksi', 'tambah_produk');
			dataTambah.append('nama', this.form.nama);
			dataTambah.append('harga', this.form.harga);
			dataTambah.append('berat', this.form.berat);
			dataTambah.append('deskripsi', this.form.deskripsi);
			dataTambah.append('file', this.form.file);

			// jalankan method axios post sambil melemparkan data_tambah ke API URL
			axios.post(this.url, dataTambah)
				.then(respon => {

					// tampung respon.data
					let data = respon.data

					console.log(data)

					// jika respon sukses ==true
					if (data.sukses) {

						// sembunyikan/tutup modal-tambah
						$("#modal-tambah").modal('hide');

						// nyalakan tombol submit
						$("button[type=submit]").prop('disabled', false);

						// bersikan form 
						this.resetForm;

						// jalankan fungsi ambil produk untuk merefresh table data produk
						this.ambil_produk();

						// isi teks pesan dari respon untuk menampilkan alert
						this.pesan.teks = data.pesan
						// isi tipe pesan dari respon
						this.pesan.tipe = data.tipe

					}
				})
				.catch(error => {
					// tangkap error jika ada
					console.log(error)
				})
		},
		isi_form(produk) {

			console.log(produk)

			this.form.id = produk.id;
			this.form.nama = produk.nama;
			this.form.harga = produk.harga;
			this.form.berat = produk.berat;
			this.form.gambar = produk.gambar;
			this.form.deskripsi = produk.deskripsi;

		},
		ubah_produk() {

			// disable semua tombol submit
			$("button[type=submit]").prop('disabled', true);

			// siapkan data
			// let data = {
			// 	aksi: 'ubah_produk',
			// 	id_produk: this.form.id,
			// 	data: {
			// 		nama: this.form.nama,
			// 		harga: this.form.harga,
			// 		berat: this.form.berat,
			// 		deskripsi: this.form.deskripsi,
			// 	}
			// }

			// siapkan data ubah dari obj formData
			let dataUbah = new FormData();

			dataUbah.append('aksi', 'ubah_produk');
			dataUbah.append('id_produk', this.form.id);
			dataUbah.append('nama', this.form.nama);
			dataUbah.append('harga', this.form.harga);
			dataUbah.append('berat', this.form.berat);
			dataUbah.append('deskripsi', this.form.deskripsi);
			dataUbah.append('file', this.form.file);

			// jalankan method axios post sambil melemparkan data ke API URL
			axios.post(this.url, dataUbah)
				.then(respon => {

					// sembunyikan/tutup modal-ubah
					$("#modal-ubah").modal('hide');

					// nyalakan tombol submit
					$("button[type=submit]").prop('disabled', false);

					// tampung respon.data
					let data = respon.data

					console.log(data)

					// jika respon sukses ==true
					if (data.sukses) {
						// jalankan fungsi ambil produk untuk merefresh table data produk
						this.ambil_produk();
					}

					// isi teks pesan dari respon untuk menampilkan alert
					this.pesan.teks = data.pesan
					// isi tipe pesan dari respon
					this.pesan.tipe = data.tipe

					// bersihkan isi form
					this.resetForm;

				})
				.catch(error => {
					// tangkap error jika ada
					console.log(error)
				})
		},
		hapus_produk(id_produk) {

			// konfirmasi user apakah yakin ingin menghapus data
			var konfirmasi = confirm('Apakah anda yakin?')

			// jika iyaa
			if (konfirmasi) {

				// siapkan data
				// let data = {
				// 	aksi: 'hapus_produk',
				// 	id_produk: id_produk,
				// }

				// siapkan data hapus dari obj formData
				let dataHapus = new FormData();

				dataHapus.append('aksi', 'hapus_produk');
				dataHapus.append('id_produk', id_produk);


				// jalankan method axios post sambil melemparkan data ke API URL
				axios.post(this.url, dataHapus)
					.then(respon => {

						// tampung respon.data
						let data = respon.data

						console.log(data)

						// jika respon sukses ==true
						if (data.sukses) {
							// jalankan fungsi ambil produk untuk merefresh table data produk
							this.ambil_produk();

							// isi teks pesan dari respon untuk menampilkan alert
							this.pesan.teks = data.pesan
							// isi tipe pesan dari respon
							this.pesan.tipe = data.tipe

						} else {
							this.pesan.teks = data.pesan
							this.pesan.tipe = data.tipe
						}

					})
					.catch(error => {
						// tangkap error jika ada
						console.log(error)
					})
			}
		},
		resetForm() {
			var self = this;
			Object.keys(this.form).forEach(function (key, index) {
				self.form[key] = '';
			});
		}
	},
})