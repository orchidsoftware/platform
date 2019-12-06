import { Controller } from 'stimulus';
// Core
import tinymce from 'tinymce/tinymce';

// A theme is also required
// import 'tinymce/themes/modern';
// import 'tinymce/themes/inlite'

// Plugins

/*
import 'tinymce/plugins/advlist'
import 'tinymce/plugins/anchor'
import 'tinymce/plugins/autolink'
import 'tinymce/plugins/autoresize'
import 'tinymce/plugins/autosave'
import 'tinymce/plugins/bbcode'
import 'tinymce/plugins/charmap'
import 'tinymce/plugins/code'
import 'tinymce/plugins/codesample'
import 'tinymce/plugins/colorpicker'
import 'tinymce/plugins/contextmenu'
import 'tinymce/plugins/directionality'
import 'tinymce/plugins/emoticons'
import 'tinymce/plugins/fullpage'
import 'tinymce/plugins/fullscreen'
import 'tinymce/plugins/help'
import 'tinymce/plugins/hr'
import 'tinymce/plugins/image'
import 'tinymce/plugins/imagetools'
import 'tinymce/plugins/importcss'
import 'tinymce/plugins/insertdatetime'
import 'tinymce/plugins/legacyoutput'
import 'tinymce/plugins/link'
import 'tinymce/plugins/lists'
import 'tinymce/plugins/media'
import 'tinymce/plugins/nonbreaking'
import 'tinymce/plugins/noneditable'
import 'tinymce/plugins/pagebreak'
import 'tinymce/plugins/paste'
import 'tinymce/plugins/preview'
import 'tinymce/plugins/print'
import 'tinymce/plugins/save'
import 'tinymce/plugins/searchreplace'
import 'tinymce/plugins/spellchecker'
import 'tinymce/plugins/tabfocus'
import 'tinymce/plugins/table'
import 'tinymce/plugins/template'
import 'tinymce/plugins/textcolor'
import 'tinymce/plugins/textpattern'
import 'tinymce/plugins/toc'
import 'tinymce/plugins/visualblocks'
import 'tinymce/plugins/visualchars'
import 'tinymce/plugins/wordcount'
*/

export default class extends Controller {
    /**
     *
     */
    connect() {
        // require.context(
        //    'file-loader?name=[path][name].[ext]&context=node_modules/tinymce!tinymce/skins',
        //    true,
        //    /.*/
        // );

        tinymce.baseURL = platform.prefix('/resources/orchid/js/tinymce');

        const selector = this.element.querySelector('.tinymce').id;
        const input = this.element.querySelector(`#${selector}`);

        let plugins = 'image media table link paste contextmenu textpattern autolink codesample';
        let toolbar1 = '';
        let inline = true;

        if (this.element.dataset.theme === 'modern') {
            plugins = 'print autosave autoresize preview paste code searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern';
            toolbar1 = 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | ltr rtl';
            inline = false;
        }

        // for remove cache
        tinymce.remove(`#${selector}`);

        tinymce.init({
            branding: false,
            selector: `#${selector}`,
            theme: this.element.dataset.theme,
            min_height: 300,
            height: 300,
            max_height: 600,
            plugins,
            toolbar1,
            insert_toolbar: 'quickimage quicktable media codesample fullscreen',
            selection_toolbar:
                'bold italic | quicklink h2 h3 blockquote | alignleft aligncenter alignright alignjustify | outdent indent | removeformat ',
            inline,
            convert_urls: false,
            image_caption: true,
            image_title: true,
            image_class_list: [
                {
                    title: 'None',
                    value: '',
                },
                {
                    title: 'Responsive',
                    value: 'img-fluid',
                },
            ],
            setup: (element) => {
                element.on('change', () => {
                    $(input).val(element.getContent());
                });
            },
            images_upload_handler: this.upload,
        });
    }

    /**
     *
     * @param blobInfo
     * @param success
     */
    upload(blobInfo, success) {
        const data = new FormData();
        data.append('file', blobInfo.blob());

        axios
            .post(platform.prefix('/systems/files'), data)
            .then((response) => {
                success(response.data.url);
            })
            .catch((error) => {
                console.warn(error);
            });
    }

    disconnect() {
        tinymce.remove(`#${this.element.querySelector('.tinymce').id}`);
    }
}
