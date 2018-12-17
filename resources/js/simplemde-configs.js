export default {
    data() {
        return {
            imageUrl: '',
            configs: {
                // previewRender: (plainText, preview) => { // Async method
                //     setTimeout(()=>{
                //         preview.innerHTML = this.customMarkdownParser(plainText)
                //     }, 250);
                //     return 'Loading...'
                // },
                shortcuts: {
                    'toggleOrderedList': 'Ctrl-Alt-K', // alter the shortcut for toggleOrderedList
                    'toggleCodeBlock': null, // unbind Ctrl-Alt-C
                    'drawTable': 'Cmd-Alt-T' // bind Cmd-Alt-T to drawTable action, which doesn't come with a default shortcut
                },
                toolbar: [
                    'bold',
                    'italic',
                    'heading',
                    'code',
                    '|',
                    'quote',
                    'ordered-list',
                    '|',
                    'link',
                    {
                        name: 'drawImage',
                        action: (editor) => {
                            this.getImage(editor);
                        },
                        className: 'fa fa-image',
                        title: 'Image'
                    },
                    '|',
                    'horizontal-rule',
                    'preview',
                    'side-by-side',
                    'fullscreen'
                ],
                lineWrapping: true,
                placeholder: 'Whats on your mind...',
            }
        }
    },
    methods: {
        drawRedText(editor) {
            var cm = editor.codemirror;
            var output = '';
            var selectedText = cm.getSelection();
            var text = selectedText || '';

            output = '*' + text + '*';
            cm.replaceSelection(output);

        },
        getImage(editor) {
            this.createElement();
            this.getAndUpload(editor);
        },
        createElement() {
            let inputEle = document.createElement('input')
            inputEle.setAttribute('type', 'file')
            inputEle.setAttribute('style', 'display:none')
            inputEle.setAttribute('id', 'file')
            inputEle.setAttribute('accept', 'image/*')
            document.getElementById('editor').appendChild(inputEle)
        },
        getAndUpload(editor) {
            let file = $('#file');
            file.click()
            file.change(() => {
                let img = event.target.files
                // console.log(img[0].realHeight)
                if (img[0].size > 204884) {
                    flash('Image size must not greater than 200kb', 'error')
                    $('#file').remove()
                    return false;
                }
                let form = new FormData();
                if (img.length) {
                    form.append('file', img[0]);
                }
                this.uploadImage(form, editor)
            })
        },
        uploadImage(form, editor) {
            wait();
            axios.post('/image-upload', form)
                .then(res => {
                    this.imageUrl = res.data.link
                    this.draw(editor);
                    $('#file').remove()
                    wait();
                })
                .catch(error => console.log(error.response.data))
        },
        draw(editor) {
            editor.options.insertTexts.image = [`![](https://${window.location.host}${this.imageUrl})`, ''];
            editor.drawImage();
        },
    }
}
