/**
 * Компонент отображения одного файла/папки для диспетчера медиа файлов
 * Created by mavsan on 22.05.18.
 * Author: Maksim Klimenko
 * Email: mavsan@gmail.com
 */

export default {
    props: {
        file: {type: Object, default: {}},
        index: Number,
    },

    data() {
        return {
            currFile: this.file,
            imageStyle: {
                backgroundImage: this.setBgImage(this.file),
            }
        }
    },

    watch: {
        file(n, o) {
            this.currFile = n;
        },

        currFile(n, o) {
            this.imageStyle.backgroundImage = this.setBgImage(n);
        }
    },

    computed: {
        isImage: function() {return ~this.currFile.type.indexOf('image')},
        isVideo: function() {return ~this.currFile.type.indexOf('video')},
        isAudio: function() {return ~this.currFile.type.indexOf('audio')},
        isFolder: function() {return this.currFile.type === 'folder'},
        isDoc: function() {return !this.isFolder && !this.isImage && !this.isVideo && !this.isAudio},
    },

    methods: {
        setBgImage: function(f) {return f.path ? 'url(' + encodeURI(f.path) + ')' : false},
        dblClick: function () {
            if(this.isFolder) {
                this.$parent.$emit('fm-folder-dbl-click', this.currFile);
            }
        }
    },

    mounted() {}
};

// Vue.component('filemanager-item', Vue.extend({
//     props: {
//         file: {type: Object, default: {}},
//         index: Number,
//     },
//
//     data() {
//         return {
//             currFile: this.file,
//             imageStyle: {
//                 backgroundImage: this.setBgImage(this.file),
//             }
//         }
//     },
//
//     watch: {
//         file(n, o) {
//             this.currFile = n;
//         },
//
//         currFile(n, o) {
//             this.imageStyle.backgroundImage = this.setBgImage(n);
//         }
//     },
//
//     computed: {
//         isImage: function() {return ~this.currFile.type.indexOf('image')},
//         isVideo: function() {return ~this.currFile.type.indexOf('video')},
//         isAudio: function() {return ~this.currFile.type.indexOf('audio')},
//         isFolder: function() {return this.currFile.type === 'folder'},
//         isDoc: function() {return !this.isFolder && !this.isImage && !this.isVideo && !this.isAudio},
//     },
//
//     methods: {
//         setBgImage: function(f) {return f.path ? 'url(' + encodeURI(f.path) + ')' : false},
//         dblClick: function () {
//             if(this.isFolder) {
//                 this.$parent.$emit('fm-folder-dbl-click', this.currFile);
//             }
//         }
//     },
//
//     mounted() {}
// }));