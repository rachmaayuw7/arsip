<div class="row">
    <div class="col-md-6 col-sm-12">
        <a onclick="window.location.href='<?= base_url()?>'" style = "color: black;cursor:pointer;"><h1 style="display: inline;" href>Arsip Surat</h1></a><h2 style="display: inline;"> >> Lihat</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php foreach($detail as $fill){
                ?>
                <p><h4>Nomor : <?= $fill->nomor_surat ?></h4></p>
                <p><h4>Kategori : <?= $fill->nama_kategori ?></h4></p>
                <p><h4>Judul : <?= $fill->judul ?></h4></p>
                <p><h4>Waktu Unggah : <?= $fill->created_at ?></h4></p>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="<?=base_url()?>/pdf/<?= $fill->file ?>" allowfullscreen></iframe>
                </div>
                <div class="template-demo">
                    <button type="button" class="btn btn-danger" id = "kembali" onclick = "window.history.back()">>> Kembali</button>
                    <button type="button" class="btn btn-warning" onclick="downloadFile('<?= $fill->file ?>')">Unduh</button>
                    <button type="button" class="btn btn-info" onclick="window.location.href='<?=base_url()?>Arsip/formEdit/<?= $fill->id_surat?>'">Edit</button>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    function downloadFile(fileName) {
        var fileUrl = '<?=base_url()?>pdf/' + fileName;

        var link = document.createElement('a');
        link.href = fileUrl;
        link.download = fileName;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>