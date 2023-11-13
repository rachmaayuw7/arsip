<div class="row">
    <div class="col-md-6 col-sm-12">
        <a onclick="window.location.href='<?= base_url()?>/Kategori'" style = "color: black;cursor:pointer;"><h1 style="display: inline;" href>Kategori</h1></a><h2 style="display: inline;"> >> Edit</h2>
        <h5 style="margin-top:7px;">Tambahkan atau edit data kategori. Jika sudah selesai, jangan lupa untuk</h5>
        <h5>mengklik tombol "Simpan"</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form action = "#" class="forms-sample">
                    <?php
                        foreach($value as $ktg){
                    ?>
                    <div class="form-group">
                        <label for="id_ktg">ID (Auto Increment)</label>
                        <input type="text" value = "<?= $ktg->id_ktg ?>" name = "id_ktg" class="form-control" id="id_ktg" placeholder="ID kategori" disabled require/>
                    </div>
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" value = "<?= $ktg->nama_kategori ?>" class="form-control" id="nama_kategori" name ="nama_kategori" placeholder="Nama Kategori" require/>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" value = "<?= $ktg->keterangan ?>" class="form-control" id="keterangan" name ="keterangan" placeholder="Keterangan" require/>
                    </div>
                    <?php
                        }
                    ?>
                    <button type="button" class="btn btn-danger mr-2" id = "kembali" onclick = "window.history.back()">>> Kembali</button>
                    <button type="button" class="btn btn-primary mr-2" onclick = "simpan()">Simpan</button>
                </form>
            </div>  
        </div>
    </div>
</div>
<script>
    function simpan(){
        var id_ktg = document.getElementById('id_ktg').value;
        var nama_kategori = document.getElementById('nama_kategori').value;
        var keterangan = document.getElementById('keterangan').value;

        var form = new FormData();
        form.append('id_ktg', id_ktg);
        form.append('nama_kategori', nama_kategori);
        form.append('keterangan', keterangan);
        
        $.ajax({
            url:`<?= base_url(); ?>Kategori/updateKtg`,
            type:'POST',
            data: form,
            contentType: false,
            processData: false,
            success: function(data){
                var value = JSON.parse(data);
                Swal.fire({
                    icon: value.icon,
                    title: value.value,
                    text: value.message
                });
            }
        });
    }
</script>