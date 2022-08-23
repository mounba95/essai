function dataTable(id, nomObjet) {
    $(id).DataTable({
        responsive: true,
        "aaSorting": [[0, "asc"]],
        oLanguage: {
            sLengthMenu: "Afficher: _MENU_ " + nomObjet + "s par page ",
            sSearch: "Rechercher : ",
            sZeroRecords: "Aucune valeur trouvee",
            sInfo: "Afficher page _PAGE_ sur _PAGES_",
            sInfoFiltered: "(Filtres sur _MAX_ )",
            sInfoEmpty: "Aucun " + nomObjet + " trouve",
            oPaginate: {
                sFirst: "<<",
                sPrevious: "<",
                sNext: ">",
                sLast: ">>"
            }
        },
        select: {
            style: 'multi'
        },
        "pagingType": "full_numbers",
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
}

$(document).ready(function() {
    dataTable("#table_utilisateur", "Utilisateur");
    dataTable("#table_visite", "Visite");
    dataTable("#table_mesvisite", "Visite");
    dataTable("#table_service", "Service");
    dataTable("#table_visiteur", "Visiteur");
    dataTable("#table_crer", "Visite");
    dataTable("#table_fermer", "Visite");
    
});