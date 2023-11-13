<div class="row">
    <div class="col-md-6 col-sm-12">
        <h1>Arsip Surat</h1>
        <h5>Berikut ini adalah surat - surat yang telah terbit dan diarsipkan</h5>
        <h5>Klik "Lihat" pada kolom aksi untuk menampilkan surat</h5>
    </div>
</div>
<div class="row" style = "margin-top:20px;">
    <div class="col-md-12 col-sm-12">
        <div class="input-group">
            <input type="text" name = "namaSurat" class="form-control" placeholder="Cari Surat" id="cariSurat">
            <div class="input-group-append">
                <button class="btn btn-sm btn-primary" type="button" id = "cari" onclick="search()">Cari</button>
            </div>
        </div>
    </div>
</div>
<table id="suratTable" class="hover" style="width:100%">
    <thead>
        <tr>
            <th>Nomor Surat</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Waktu Pengarsipan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<button type="button" class="btn btn-primary" onclick="window.location.href='<?= base_url()?>Arsip/formSurat'">Arsipkan Surat</button>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
        table();
    });

    function table(){
        $("#suratTable").DataTable({
            searching: false,
            lengthChange: false,
            ajax: {
                url: '<?= base_url("Arsip/showData") ?>',
            },
            columns: [
                { data: 'nomor_surat' },
                { data: 'nama_kategori' },
                { data: 'judul' },
                { data: 'created_at'},
                { 
                    render: function(data, type, row, meta) {
                        var button = '<button type="button" class="btn btn-danger" onclick="deleteSurat(' + row.id_surat +')">Hapus</button>' +
                            '<button type="button" class="btn btn-warning" id="unduhSurat" onclick="downloadFile(\'' + row.file + '\')">Unduh</button>' +
                            '<button type="button" class="btn btn-info" id="lihatSurat" onclick="window.location.href=\'<?= base_url() ?>Arsip/getLihatSurat/' + row.id_surat + '\'">Lihat>></button>';
                        return button;
                        
                    }
                }
            ]
        });
    }

    function search(){
        var input = document.getElementById("cariSurat").value
        $('#suratTable').DataTable().destroy();
        $("#suratTable").DataTable({
            searching: false,
            lengthChange: false,
            ajax: {
                url: '<?= base_url("Arsip/showData") ?>',
                type: 'POST',
                data: {
                    namaSurat: input
                }
            },
            columns: [
                { data: 'nomor_surat' },
                { data: 'nama_kategori' },
                { data: 'judul' },
                { data: 'created_at'},
                { 
                    render: function(data, type, row, meta) {
                        var button = '<button type="button" class="btn btn-danger" onclick="deleteSurat(' + row.id_surat +')">Hapus</button>' +
                            '<button type="button" class="btn btn-warning" id="unduhSurat" onclick="downloadFile(\'' + row.file + '\')">Unduh</button>' +
                            '<button type="button" class="btn btn-info" id="lihatSurat" onclick="window.location.href=\'<?= base_url() ?>Arsip/getLihatSurat/' + row.id_surat + '\'">Lihat>></button>';
                        return button;


                        
                    }
                }
            ]
        });
    }
    function downloadFile(fileName) {
        var fileUrl = '<?=base_url()?>pdf/' + fileName;

        var link = document.createElement('a');
        link.href = fileUrl;
        link.download = fileName;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function deleteSurat(id_surat){
        var formData = new FormData();
        formData.append('id_surat', id_surat);
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
                        url: `Arsip/delSurat`,
                        type: "POST",
                        data: formData,
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

    function lihatDetail(id_surat){
        var formData = new FormData();
        formData.append('id_surat', id_surat);
        $.ajax({
            url: `Arsip/getLihatSurat/${id_surat}`,
            type: "POST",
            contentType: false,
            processData: false,
            success: function(data){
                val = JSON.parse(data);
                console.log(val);
            }
        });
    }
</script>


