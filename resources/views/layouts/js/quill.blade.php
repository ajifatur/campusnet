<script type="text/javascript" src="https://campusdigital.id/assets/plugins/quill/quill.min.js"></script>
<script src="https://cdn.rawgit.com/kensnyder/quill-image-resize-module/3411c9a7/image-resize.min.js"></script>
<script type="text/javascript">
    let QuillEditor = (selector) => {
        if($(selector).length === 1) {
            let quill = new Quill(selector, {
                modules: {
                    toolbar: [
                        [{'header': [1, 2, 3, 4, 5, 6, false]}],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{'script': 'sub'}, {'script': 'super'}],
                        ['link', 'image'],
                        [{'list': 'ordered'}, {'list': 'bullet'}],
                        [{'align': [] }],
                        [{'indent': '-1'}, {'indent': '+1'}],
                        [{'direction': 'rtl'}],
                        [{'color': []}, {'background': []}],
                        ['clean']
                    ],
                    imageResize: {
                        displaySize: true
                    }
                },
                placeholder: 'Tulis sesuatu...',
                theme: 'snow',
                readOnly: false
            });
        }
        else quill = null;

        return quill;
    }
</script>