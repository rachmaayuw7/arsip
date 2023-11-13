<div class="row">
    <div class="col-md-6 col-sm-12">
        <a onclick="window.location.href='<?= base_url()?>'" style = "color: black;cursor:pointer;"><h1 style="display: inline;" href>Arsip Surat</h1></a><h2 style="display: inline;"> >> Unggah</h2>
        <h5 style="margin-top:7px;">Unggah surat yang telah terbit pada form ini untuk diarsipkan</h5>
        <h5>Catatan : <span style = "color: red;">- Gunakan file berformat *pdf</span></h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form action = "#" class="forms-sample">
                    <div class="form-group">
                        <label for="nomorSurat">Nomor Surat</label>
                        <input type="text" name = "nomorSurat" class="form-control" id="nomorSurat" placeholder="Nomor Surat" require/>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                            <select class="form-control" id="kategori" name = "kategori">
                            <?php
                                foreach($kategori as $ktg){
                            ?>
                            <option value = <?= $ktg->id_ktg ?>><?= $ktg->nama_kategori ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name ="judul" placeholder="Judul" require/>
                    </div>
                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="fileUpload[]" id = "fileUpload" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" id = "fileUploadName" accept=".pdf" disable placeholder="Upload PDF file" require/>
                            <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger mr-2" id = "kembali" onclick = "window.history.back()">>> Kembali</button>
                    <button type="button" class="btn btn-primary mr-2" onclick = "simpan()">Simpan</button>
                </form>
            </div>  
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

    });

    function simpan(){
        var nomors = document.getElementById("nomorSurat").value;
        var kategoris = document.getElementById("kategori").value;
        var juduls = document.getElementById("judul").value;
        var fileUploads = document.getElementById("fileUpload").files[0];
        console.log(fileUploads)
        if((nomors != "") && (juduls != "") && (fileUploads != ""))
        {
            if(fileUploads.type != "application/pdf")
            {
                Swal.fire({
                    icon: "error",
                    title: "File bukan PDF",
                    text: "Mohon upload file PDF",
                });
            } else {
                var formData = new FormData();
                formData.append('nomorSurat', nomors);
                formData.append('kategori', kategoris);
                formData.append('judul', juduls);
                formData.append('fileUpload', fileUploads);
                $.ajax({
                    url: `<?= base_url() ?>Arsip/saveSurat`,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        value = JSON.parse(data)
                        console.log(value);
                        Swal.fire({
                            icon: value.icon,
                            title: value.value,
                            text: value.message
                        });
                    } 
                });
            }
        } else {
            Swal.fire({
                icon: "error",
                title: "Data belum lengkap",
                text: "Mohon lengkapi data!",
            });
        }
    }
</script>