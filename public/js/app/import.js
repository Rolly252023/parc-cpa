$(document).ready(function () {
    $('#updateEtatSilenceButton').on('click', function () {
        // Afficher un indicateur de chargement
        $('#updateStatus').html('Mise à jour en cours...');

        $.ajax({
            url: '/admin/import/update-etat-silence',
            method: 'POST',
            success: function (response) {
                if (response.status === 'success') {
                    $('#updateStatus').html('<span style="color: green;">' + response.message + '</span>');
                } else {
                    $('#updateStatus').html('<span style="color: red;">' + response.message + '</span>');
                }
            },
            error: function (error) {
                $('#updateStatus').html('<span style="color: red;">Erreur lors de la mise à jour.</span>');
            }
        });
    });

    $('#upload-form').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
    
        // 1) désactive le bouton et affiche le spinner d'upload
        $('#upload-btn')
            .prop('disabled', true)
            .html('Envoi en cours… <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#upload-result').html('');
    
        // 2) upload du fichier
        $.ajax({
            url: '/admin/imports/bridge/upload',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (!response.success) {
                    // échec upload
                    $('#upload-result').html(
                        '<div class="alert alert-danger">' + response.message + '</div>'
                    );
                    $('#upload-btn')
                        .prop('disabled', false)
                        .html('Envoyer');
                    return;
                }
    
                // 3) upload OK, on passe à l'import
                $('#upload-result').html(
                    '<div class="alert alert-info">Fichier envoyé : ' + response.filepath +
                    ' — Lancement de l’import… <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div>'
                );
    
                $.post('/admin/imports/bridge/import', { path: response.filepath })
                    .done(function (importResponse) {
                        if (importResponse.success) {
                            $('#upload-result').html(
                                '<div class="alert alert-success">Import terminé avec succès.</div>'
                            );
                        } else {
                            $('#upload-result').html(
                                '<div class="alert alert-danger">Erreur import : ' +
                                    importResponse.message +
                                '</div>'
                            );
                        }
                    })
                    .fail(function () {
                        $('#upload-result').html(
                            '<div class="alert alert-danger">Échec HTTP pendant l’import.</div>'
                        );
                    })
                    .always(function () {
                        // 4) on réactive le bouton quoi qu’il arrive
                        $('#upload-btn')
                            .prop('disabled', false)
                            .html('Envoyer');
                    });
            },
            error: function () {
                $('#upload-result').html(
                    '<div class="alert alert-danger">Erreur lors de l’envoi du fichier.</div>'
                );
                $('#upload-btn')
                    .prop('disabled', false)
                    .html('Envoyer');
            }
        });
    });
    
});

function deleteFile(filePath, rowIndex) {
    if (!confirm("Voulez-vous vraiment supprimer ce fichier ?")) {
        return;
    }

    $.ajax({
        url: '/admin/files/delete',
        method: 'POST',
        data: {
            path: filePath
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function (data) {
            if (data.success) {
                const row = document.getElementById('file-row-' + rowIndex);
                if (row) {
                    row.remove();
                }
            } else {
                alert("Erreur : " + (data.message || "suppression échouée"));
            }
        },
        error: function () {
            alert("Une erreur s'est produite lors de la suppression du fichier.");
        }
    });
}

function loadBridge(route, filePath) {
    $.post(route, { path: filePath })
      .done(function (importResponse) {
        if (importResponse.status === 'success') {
          $('#upload-result').html(
            '<div class="alert alert-success">Import terminé avec succès.</div>'
          );
        } else {
          $('#upload-result').html(
            '<div class="alert alert-danger">Erreur import : ' +
              importResponse.message +
            '</div>'
          );
        }
      })
      .fail(function () {
        $('#upload-result').html(
          '<div class="alert alert-danger">Échec HTTP pendant l’import.</div>'
        );
      })
      .always(function () {
        $('#btn-import').prop('disabled', false);
      });
  }
  

