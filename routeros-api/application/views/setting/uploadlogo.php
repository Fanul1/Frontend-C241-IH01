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
                                <?= $galat; ?>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="pd-10"><?= $_format_file_name ?> : logo-<?= $session; ?>.png </div>
                                    <div class="input-group">
                                        <div class="input-group-4 col-box-8">
                                            <input style="cursor: pointer;" type="file" class="group-item group-item-l" name="UploadLogo" onchange="previewImage(event)">
                                        </div>
                                        <div class="input-group-2 col-box-4">
                                            <input style="cursor: pointer; font-size: 14px; padding:8px;" class="group-item group-item-r" type="submit" value="<?= $_upload ?>" title="Upload logo" name="submit">
                                        </div>
                                    </div>
                                    <div class="mr-t-10">
                                        <img id="preview" src="" alt="Preview Image" style="display: none; max-height: 200px;">
                                    </div>
                                </form>
                            </div>
                            <div class="mr-t-10">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?= $_list_logo ?></th>
                                            <th><?= $_action ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dir = "./img";
                                        // Open a directory, and read its contents
                                        if (is_dir($dir)) {
                                            if ($dh = opendir($dir)) {
                                                while (($file = readdir($dh)) !== false) {
                                                    if ($file != "." && $file != "..") {
                                                        if (substr($file, 0, 5) != "logo-" ||
                                                            substr($file, -5) == ".html" ||
                                                            substr($file, -4) == ".php" ||
                                                            substr($file, -4) == ".jpg" ||
                                                            substr($file, -4) == ".bak") {
                                                            continue;
                                                        } else { ?>
                                                            <tr>
                                                                <td><a href="javascript:window.open('./img/<?= $file; ?>','_blank','width=300,height=300')"><img height="30px" src="./img/<?= $file; ?>" title="Open <?= $file; ?>"></a><br><span><?= $file; ?></span></td>
                                                                <td><a class="btn bg-danger" href="javascript:void(0)" onclick="if(confirm('Sure to delete <?= $file; ?> ?')){window.location='./admin.php?id=remove-logo&logo=<?= $file; ?>&session=<?= $session ?>'}else{}"><i class="fa fa-trash"></i> <?= $_delete ?></a></td>
                                                            </tr>
                                                        <?php }
                                                    }
                                                }
                                                closedir($dh);
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
