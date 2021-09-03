/*
INCLUIR SEMPRE NAS PÁGINAS QUE UTILIZAR ESSE CÓDIGO

<!-- include libraries(jQuery, bootstrap) -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
*/

class EditorTexto {
    constructor(id, html) {
        this.id = id;
        this.elemento = $('#' + this.id);
        this.estilos = [];
        this.html = html;
    }
    inicializar() {
        this.obterEstilos();
        this.formatarHTML();

        this.elemento.summernote(
            {
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            }
        );
    }
    formatarHTML() {
        if (this.estilos.length > 0) {
            for (let index = 0; index < this.estilos.length; index++) {
                let estilo = this.estilos[index];
                this.html = this.html.replaceAll(estilo, '<!-- @estilo_' + index.toString() + ' -->');
            }
        }

        this.elemento.summernote('code', this.html);
    }
    obterEstilos() {
        this.estilos = [];

        let regexLinks = new RegExp('(<link.*>)', 'g');
        let matchesLinks = this.html.match(regexLinks);

        let regexScripts = new RegExp('(<script.*</script>)', 'g');
        let matchesScripts = this.html.match(regexScripts);

        this.estilos = matchesLinks.concat(matchesScripts);
    }
    obterHTML() {
        this.html = this.elemento.summernote('code');

        if (this.estilos.length > 0) {
            for (let index = 0; index < this.estilos.length; index++) {
                let estilo = this.estilos[index];
                this.html = this.html.replaceAll('<!-- @estilo_' + index.toString() + ' -->', estilo);
            }
        }

        return this.html;
    }
}