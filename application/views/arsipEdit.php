<div class="row">
    <div class="col-md-6 col-sm-12">
        <a onclick="window.location.href='<?= base_url()?>'" style = "color: black;cursor:pointer;"><h1 style="display: inline;" href>Arsip Surat</h1></a><h2 style="display: inline;"> >> Unggah</h2>
        <h5 style="margin-top:7px;">Edit surat yang telah terbit pada form ini untuk diarsipkan</h5>
        <h5>Catatan : <span style = "color: red;">- Gunakan file berformat *pdf</span></h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php 
                    foreach($detail as $fill) {
                ?>
                <form action = "#" class="forms-sample">
                    <div class="form-group">
                        <label for="nomorSurat">Nomor Surat</label>
                        <input type="text" value = "<?= $fill->nomor_surat ?>" name = "nomorSurat" class="form-control" id="nomorSurat" placeholder="Nomor Surat" require/>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                            <select class="form-control" id="kategori" name = "kategori">
                            <?php
                                foreach($kategori as $ktg){
                                $selected = ($ktg->id_ktg == $fill->id_ktg) ? 'selected' : '';
                            ?>
                            <option value="<?=$ktg->id_ktg?>" <?= $selected ?>><?= $ktg->nama_kategori ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" value = "<?=$fill->judul?>" class="form-control" id="judul" name ="judul" placeholder="Judul" require/>
                    </div>
                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="fileUpload[]"  id = "fileUpload" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" value = "<?=$fill->file?>" id = "fileUploadName" accept=".pdf" disable placeholder="Upload PDF file" require/>
                            <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger mr-2" id = "kembali" onclick = "window.history.back()">>> Kembali</button>
                    <button type="button" class="btn btn-primary mr-2" onclick = "update()">Update</button>
                    <?php
                        }
                    ?>
                </form>
            </div>  
        </div>
    </div>
</div>
<script>
    var id;
    $(document).ready(function(){
        id = <?php echo json_encode($detail[0]->id_surat); ?>;
    });

    function update(){
        var nomors = document.getElementById("nomorSurat").value;
        var kategoris = document.getElementById("kategori").value;
        var juduls = document.getElementById("judul").value;
        var fileUploads = document.getElementById("fileUpload").files[0];
        if(fileUploads===undefined){
            fileUploads = "";
        } 
        if((nomors != "") && (juduls != ""))
        {
            if((fileUploads.type != "application/pdf") && fileUploads !== ""){
                Swal.fire({
                    icon: "error",
                    title: "File bukan PDF",
                    text: "Mohon upload file PDF",
                });
            } else {
                var formData = new FormData();
                formData.append('id_surat', id)
                formData.append('nomorSurat', nomors);
                formData.append('kategori', kategoris);
                formData.append('judul', juduls);
                formData.append('fileUpload', fileUploads);
                $.ajax({
                    url: `<?= base_url() ?>Arsip/updateSurat`,
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