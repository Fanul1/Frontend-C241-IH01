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
                    <textarea id="templateEditor" name="template" rows="20" class="form-control"><?= $template ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Template</button>
                <button type="button" class="btn btn-secondary" onclick="previewTemplate()">Preview Template</button>
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

    function previewTemplate() {
        var templateContent = editor.getValue();
        var previewWindow = window.open('', 'Template Preview', 'height=600,width=800');
        previewWindow.document.write('<html><head><title>Template Preview</title></head><body>');
        previewWindow.document.write(templateContent);
        previewWindow.document.write('</body></html>');
        previewWindow.document.close();
        previewWindow.print();
    }
</script>