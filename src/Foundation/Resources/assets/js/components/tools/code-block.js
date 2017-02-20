/**
 * Created by joker on 17.02.17.
 */
document.addEventListener('DOMContentLoaded', function () {
    const editorId = 'code-editor';
    const codePreviewId = 'preview-context';
    const hiddenFieldid = 'code-data';

    var escape = function(html) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&#34;',
            "'": '&#39;'
        };

        var repl = function(c) { return map[c]; };

        return html.replace(/[&<>'"]/g, repl);
    };

    if(document.getElementById(editorId) != null) {
        var editor = ace.edit(editorId);
        var hiddenCodeVal = $('#' + hiddenFieldid);

        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/javascript");
        editor.setFontSize(20);

        var showCode = function(code) {
            $('#' + codePreviewId).html(code);
        };

        editor.on('change', function () {
            var code = editor.getValue();
            var escapedCode = escape(code);

            hiddenCodeVal.val(escapedCode);
        });

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