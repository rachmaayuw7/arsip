<div class="row">
    <div class="col-md-6 col-sm-12">
        <h1>Kategori Surat</h1>
        <h5>Berikut ini adalah kategori yang bisa digunakan untuk melabeli surat.</h5>
        <h5>Klik "Tambah" pada kolom aksi untuk menambahkan kategori baru.</h5>
    </div>
</div>
<div class="row" style = "margin-top:20px;">
    <div class="col-md-12 col-sm-12">
        <div class="input-group">
            <input type="text" name = "cariKtg" class="form-control" placeholder="Cari Kategori" id="cariKtg">
            <div class="input-group-append">
                <button class="btn btn-sm btn-primary" type="button" id = "cari" onclick="search()">Cari</button>
            </div>
        </div>
    </div>
</div>
<table id="kategoriTable" class="hover" style="width:100%">
    <thead>
        <tr>
            <th>ID Kategori</th>
            <th>Nama Kategori</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<button type="button" class="btn btn-primary" onclick="window.location.href='<?= base_url()?>Kategori/formKategori'">
    <span>[+] Tambah Kategori</span>
</button>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
        table();
    });

    function table(){
        $("#kategoriTable").DataTable({
            searching: false,
            lengthChange: false,
            ajax: {
                url: `<?= base_url("Kategori/showData") ?>`,
            },
            columns: [
                { data: 'id_ktg' },
                { data: 'nama_kategori' },
                { data: 'keterangan' },
                { 
                    render: function(data, type, row, meta) {
                        var button = '<button type="button" class="btn btn-danger" onclick = "DeleteKtg('+ row.id_ktg +')">Hapus</button>' +
                                    '<button type="button" class="btn btn-warning" id="unduhSurat" onclick="window.location.href=\'<?= base_url() ?>Kategori/editKtg/' + row.id_ktg + '\'">Edit</button>';
                        return button;
                        
                    }
                }
            ]
        });
    }

    function search(){
        $("#kategoriTable").DataTable().destroy();
        var input = document.getElementById("cariKtg").value
        console.log(input);
        $("#kategoriTable").DataTable({
            searching: false,
            lengthChange: false,
            ajax: {
                url: `<?= base_url("Kategori/showData") ?>`,
                data: {
                    nama_kategori: input
                },
                method: "POST"
            },
            columns: [
                { data: 'id_ktg' },
                { data: 'nama_kategori' },
                { data: 'keterangan' },
                { 
                    render: function(data, type, row, meta) {
                        var button = '<button type="button" class="btn btn-danger" onclick = "DeleteKtg('+ row.id_ktg +')">Hapus</button>' +
                            '<button type="button" class="btn btn-warning" id="unduhSurat" onclick="window.location.href=\'<?= base_url() ?>Kategori/editKtg/' + row.id_ktg + '\'">Edit</button>';
                        return button;
                        
                    }
                } 
            ]
        });
    }

    function DeleteKtg(id){
        var form = new FormData();
        form.append('id_ktg', id);
        Swal.fire({
            title: "Yakin hapus data?",
            text: "Data tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `Kategori/deleteKtg`,
                        type: "POST",
                        data: form,
                        contentType: false,
                        processData: false,
                        success: function(data){
                            val = JSON.parse(data);
                            console.log(val);
                            Swal.fire({
                                title: val.value,
                                text: val.message,
                                icon: val.icon
                            });
                            $('#cari').trigger('click');
                        }
                    });
                }
        });
    }
</script>