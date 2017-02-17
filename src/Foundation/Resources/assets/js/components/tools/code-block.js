/**
 * Created by joker on 17.02.17.
 */
document.addEventListener('DOMContentLoaded', function () {
    const elementId = 'code-editor';

    if(document.getElementById(elementId) != null) {
        var editor = ace.edit(elementId);

        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/javascript");
    }
});