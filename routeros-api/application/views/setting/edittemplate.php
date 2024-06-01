<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Template Editor</h3>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action="<?= base_url('settings/saveTemplate') ?>" method="post">
                <div class="form-group">
                    <textarea id="templateEditor" name="template" rows="20" class="form-control">
<style>
    .qrcode {
        height: 80px;
        width: 80px;
    }
</style>

<table class="voucher" style="width: 220px;">
    <tbody>
        <tr>
            <td style="text-align: left; font-size: 14px; font-weight: bold; border-bottom: 1px black solid;">
                <img src="<?= $logo; ?>" alt="logo" style="height: 30px; border: 0;"> <?= $hotspotname; ?>
                <span id="num"><?= " [$num]"; ?></span>
            </td>
        </tr>
        <tr>
            <td>
                <table style="text-align: center; width: 210px; font-size: 12px;">
                    <tbody>
                        <?php if ($usermode == "vc") { ?>
                        <tr>
                            <td>Kode Voucher</td>
                        </tr>
                        <tr>
                            <td style="width: 100%; border: 1px solid black; font-weight: bold; font-size: 16px;"><?= $username; ?></td>
                        </tr>
                        <?php } elseif ($usermode == "up") { ?>
                        <?php if ($qr == "yes") { ?>
                        <tr>
                            <td>Username</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; font-weight: bold;"><?= $username; ?></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; font-weight: bold;"><?= $password; ?></td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td>Username</td>
                            <td>Password</td>
                        </tr>
                        <tr style="font-size: 14px;">
                            <td style="border: 1px solid black; font-weight: bold;"><?= $username; ?></td>
                            <td style="border: 1px solid black; font-weight: bold;"><?= $password; ?></td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </td>
            <?php if ($qr == "yes") { ?>
            <td><?= $qrcode ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="2" style="border-top: 1px solid black; font-weight: bold; font-size: 16px;">
                <?= $validity; ?> <?= $timelimit; ?> <?= $datalimit; ?> <?= $price; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold; font-size: 12px;">Login: http://<?= $dnsname; ?></td>
        </tr>
    </tbody>
</table>
                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Template</button>
            </form>
        </div>
    </section>
</div>

<!-- CodeMirror CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/material.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/xml/xml.min.js"></script>

<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("templateEditor"), {
        lineNumbers: true,
        mode: "xml",
        theme: "material"
    });
</script>
