/**
 * Created by joker on 17.02.17.
 */
document.addEventListener('DOMContentLoaded', function () {
    const editorId = 'code-editor';
    const codePreviewId = 'preview-context';

    if(document.getElementById(editorId) != null) {
        var editor = ace.edit(editorId);

        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/javascript");
        editor.setFontSize(20);

        var showCode = function(code) {
            $('#' + codePreviewId).html(code);
        };

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).data('target');

            if(target == '#tab-predprosmotr') {
                var code = editor.getValue();

                if(code != '') {
                    showCode(code);
                }
            }
        });
    }
});