// Copyright (c) 2022. | David Annebicque | IUT de Troyes  - All Rights Reserved
// @file /Users/davidannebicque/Sites/intranetV3/assets/js/pages/adm.configuration.js
// @author davidannebicque
// @project intranetV3
// @lastUpdate 07/07/2022 13:30
import $ from 'jquery'
import { addCallout } from '../util'
import Routing from 'fos-router'

$(document).on('change', '.changeOption', function (e) {
  e.preventDefault()
  e.stopPropagation()

  $.ajax({
    url: Routing.generate('administration_configuration_change_option'),
    method: 'POST',
    data: {
      type: $(this).data('type'),
      value: $(this).prop('checked'),
      name: $(this).attr('name'),
      id: $(this).data('id'),
    },
    success() {
      addCallout('Configuration enregistrée', 'success')
    },
    error() {
      addCallout('Erreur lors de l\'enregistrement de la configuration', 'danger')
    },
  })
})

$(document).on('change', '.changeOptionSelect', function () {
  $.ajax({
    url: Routing.generate('administration_configuration_change_option'),
    method: 'POST',
    data: {
      type: $(this).data('type'),
      value: $(this).val(),
      name: $(this).attr('name'),
      id: $(this).data('id'),
    },
    success() {
      addCallout('Configuration enregistrée', 'success')
    },
    error() {
      addCallout('Erreur lors de l\'enregistrement de la configuration', 'danger')
    },
  })
})

$(document).on('change', '.activeAnneeUniversitaire', function (e) {
  e.preventDefault()
  e.stopPropagation()

  $.ajax({
    url: Routing.generate('sa_annee_universitaire_change_active', { annee: $(this).data('id') }),
    method: 'POST',
    data: {
      value: $(this).prop('checked'),
    },
    success() {
      addCallout('Configuration enregistrée', 'success')
    },
    error() {
      addCallout('Erreur lors de l\'enregistrement de la configuration', 'danger')
    },
  })
})
