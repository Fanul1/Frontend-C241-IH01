<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Edit Template Voucher</h3>

            <!-- Create a simple CodeMirror instance -->
            <link rel="stylesheet" href="./css/editor.min.css">
            <script src="./js/editor.min.js"></script>

            <style>
                .CodeMirror {
                    border: 1px solid #2f353a;
                    height: 505px;
                }

                textarea {
                    font-size: 12px;
                    border: 1px solid #2f353a;
                }
            </style>

            <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fa fa-edit"></i> <?= $_template_editor ?></h3>
                        </div>
                        <div class="card-body">
                            <form autocomplete="off" method="post" action="">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-4 col-box-12">
                                                    <button type="submit" title="Save template" class="btn bg-primary" name="save">
                                                        <i class="fa fa-save"></i> <?= $_save ?>
                                                    </button>
                                                    <a class="btn bg-green" href="<?= $popup ?>" title="View voucher with Logo">
                                                        <i class="fa fa-image"></i>
                                                    </a>
                                                    <a class="btn bg-green" href="<?= $popupQR ?>" title="View voucher with QR">
                                                        <i class="fa fa-qrcode"></i>
                                                    </a>
                                                </div>
                                                <div class="col-8 pd-t-5 pd-b-5 col-box-12">
                                                    <div class="input-group">
                                                        <div class="input-group-3">
                                                            <div class="group-item group-item-l pd-2p5 text-center">Template</div>
                                                        </div>
                                                        <div class="input-group-3">
                                                            <select style="padding:4.2px;" class="group-item group-item-m" onchange="window.location.href=this.value+'&session=<?= $session; ?>';">
                                                                <option><?= ucfirst($telplate); ?></option>
                                                                <option value="./admin.php?id=editor&template=default">Default</option>
                                                                <option value="./admin.php?id=editor&template=thermal">Thermal</option>
                                                                <option value="./admin.php?id=editor&template=small">Small</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group-3">
                                                            <div class="group-item group-item-m pd-2p5 text-center">Reset</div>
                                                        </div>
                                                        <div class="input-group-3">
                                                            <select style="padding:4.2px;" class="group-item group-item-r" onchange="window.location.href=this.value+'&session=<?= $session; ?>';">
                                                                <option><?= ucfirst($telplate); ?></option>
                                                                <option value="./admin.php?id=editor&template=rdefault">Default</option>
                                                                <option value="./admin.php?id=editor&template=rthermal">Thermal</option>
                                                                <option value="./admin.php?id=editor&template=rsmall">Small</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <textarea class="bg-dark" id="editorMikhmon" name="editor" style="width:100%" height="700">
                                    <?php
                                    switch ($telplate) {
                                        case "default":
                                            echo file_get_contents('./voucher/template.php');
                                            break;
                                        case "thermal":
                                            echo file_get_contents('./voucher/template-thermal.php');
                                            break;
                                        case "small":
                                            echo file_get_contents('./voucher/template-small.php');
                                            break;
                                        case "rdefault":
                                            echo file_get_contents('./voucher/default.php');
                                            break;
                                        case "rthermal":
                                            echo file_get_contents('./voucher/default-thermal.php');
                                            break;
                                        case "rsmall":
                                            echo file_get_contents('./voucher/default-small.php');
                                            break;
                                    }
                                    ?>
                                </textarea>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            <h3>Variable</h3>
                        </div>
                        <div class="card-body">
                            <textarea id="var" class="bg-dark" readonly rows="39" style="width:100%" disabled>
                                <?= file_get_contents('./voucher/variable.php'); ?>
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                var _0x5b73 = [
                    "undefined", "MikhmonSession", "innerHTML", "getElementById", "setItem", "Please use Google Chrome",
                    "getItem", "null", "", "Mikhmon bajakan! :)", "editorMikhmon", "application/x-httpd-php",
                    "toMatchingTag", "fromTextArea", "theme", "material", "setOption"
                ];
                if (typeof (Storage) !== _0x5b73[0]) {
                    sessionStorage[_0x5b73[4]](_0x5b73[1], document[_0x5b73[3]](_0x5b73[1])[_0x5b73[2]]);
                } else {
                    alert(_0x5b73[5]);
                }
                var session = sessionStorage[_0x5b73[6]](_0x5b73[1]);
                if (session === _0x5b73[7] || session === _0x5b73[8]) {
                    alert(_0x5b73[9]);
                }
                var editor = CodeMirror[_0x5b73[13]](document[_0x5b73[3]](_0x5b73[10]), {
                    lineNumbers: true,
                    matchBrackets: true,
                    mode: _0x5b73[11],
                    indentUnit: 4,
                    indentWithTabs: true,
                    lineWrapping: true,
                    viewportMargin: Infinity,
                    matchTags: { bothTags: true },
                    extraKeys: { "Ctrl-J": _0x5b73[12] }
                });
                editor[_0x5b73[16]](_0x5b73[14], _0x5b73[15]);
            </script>
        </div>
    </div>
</div>
