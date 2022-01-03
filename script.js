var form_input = document.getElementsByClassName('form_input');
for (let i = 0; i < form_input.length; i++) {
    form_input[i].addEventListener('keyup', function () { //esto recorre todos los inputs del formulario y revisa que tengan algo, los mueve o no.
        if (this.value.length >= 1) {
            this.nextElementSibling.classList.add('fijar');
            if (i == form_input.length - 1) { //este es el caso especial del ultimo input, que no tiene que tener margin bottom tan grande
                this.nextElementSibling.classList.add('fijar2');
            }
        } else {
            this.nextElementSibling.classList.remove('fijar', 'fijar2');
        }
    })
}

function mostrar_contraseña() {
    var p = document.getElementById('pass');

    if (p.type == "password")
        p.setAttribute('type', 'text');
    else
        p.setAttribute('type', 'password');
}

const $btnExportar = document.querySelector("#btnExportar"),
    $tabla = document.querySelector("#tabla");
let $nombre = document.getElementById('Nombre_usuario').innerText;

$btnExportar.addEventListener("click", function () {
    let tableExport = new TableExport($tabla, {
        exportButtons: false, // No queremos botones
        filename: $nombre, //Nombre del archivo de Excel
        sheetname: "Reporte de prueba", //Título de la hoja
        ignoreCols: (3),
    });
    let datos = tableExport.getExportData();
    let preferenciasDocumento = datos.tabla.xlsx;
    tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
});


