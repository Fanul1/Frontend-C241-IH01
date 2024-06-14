<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Upload Logo</h3>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-upload"></i> <?= $_upload_logo ?></h3>
                        </div>
                        <div class="card-body">
                            <div>
                                <?php if (isset($galat)) : ?>
                                    <div class="alert alert-danger"><?= $galat ?></div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('success')) : ?>
                                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                                <?php endif; ?>
                                <form action="<?php echo base_url('settings/uploadLogoGambar'); ?>" method="post" enctype="multipart/form-data">
                                    <div class="pd-10"><?= $_format_file_name ?> : logoVoucher.png </div>
                                    <div class="d-flex align-items-center">
                                        <input style="cursor: pointer;" type="file" class="form-control-file mr-2" name="UploadLogo" onchange="previewImage(event)">
                                        <button type="submit" class="btn btn-primary ml-2" title="Upload logo" name="submit">Upload</button>
                                    </div>
                                    <div class="mr-t-10 mt-3">
                                        <img id="preview" src="" alt="Preview Image" style="display: none; max-height: 200px;">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function() {
        const preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
