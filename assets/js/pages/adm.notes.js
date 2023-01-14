// Copyright (c) 2023. | David Annebicque | IUT de Troyes  - All Rights Reserved
// @file /Users/davidannebicque/Sites/intranetV3/assets/js/pages/adm.notes.js
// @author davidannebicque
// @project intranetV3
// @lastUpdate 14/01/2023 14:41
import $ from 'jquery'
import { addCallout } from '../util'
import Routing from 'fos-router'

$(document).on('click', '.optAfficher', function () {
  const evaluation = $(this).data('id')
  const $child = $(this).children('i')
  const $a = $(this)
  $.ajax({
    url: Routing.generate('administration_evaluation_visibilite', { uuid: evaluation }),
    success() {
      if ($child.hasClass('fa-eye')) {
        $a.addClass('btn-danger')
        $a.removeClass('btn-info').removeClass('btn-outline')

        $child.removeClass('fa-eye')
        $child.addClass('fa-eye-slash')
        $a.attr('title', 'Evaluation masquée. Rendre visible l\'évaluation')
      } else {
        $a.removeClass('btn-danger')
        $a.addClass('btn-info').addClass('btn-outline')
        $child.removeClass('fa-eye-slash')
        $child.addClass('fa-eye')
        $a.attr('title', 'Evaluation visible. Masquer l\'évaluation')
      }
      addCallout('Visibilité de l\'évaluation modifiée !', 'success')
    },
    error() {
      addCallout('Une erreur est survenue !', 'danger')
    },
  })
})

$(document).on('click', '.optVerrouiller', function () {
  const evaluation = $(this).data('id')
  const $child = $(this).children('i')
  const $a = $(this)
  $.ajax({
    url: Routing.generate('administration_evaluation_modifiable', { uuid: evaluation }),
    success() {
      if ($child.hasClass('fa-lock-open')) {
        $a.addClass('btn-danger')
        $a.removeClass('btn-warning').removeClass('btn-outline')
        $child.removeClass('fa-lock-open')
        $child.addClass('fa-lock')
        $a.attr('data-original-title', 'Modification interdite. Autoriser la modificaiton')
      } else {
        $a.removeClass('btn-danger')
        $a.addClass('btn-warning').addClass('btn-outline')
        $child.removeClass('fa-lock')
        $child.addClass('fa-lock-open')
        $a.attr('data-original-title', 'Modification autorisée. Interdire la modification')
      }
      addCallout('Vérouillage de l\'évaluation modifiée !', 'success')
    },
    error() {
      addCallout('Une erreur est survenue !', 'danger')
    },
  })
})

$(document).on('click', '#voirDetailAbsent', (e) => {
  e.preventDefault()
  $('#detailIncoherent').hide()
  $('#detailAbsent').toggle()
})

$(document).on('click', '#voirDetailIncoherent', (e) => {
  e.preventDefault()
  $('#detailIncoherent').toggle()
  $('#detailAbsent').hide()
})

$(document).on('click', '.remplacerParZero', function (e) {
  e.preventDefault()
  updateNote($(this).data('note'), 'zero').then(
    (data) => {
      $(`#note_${data}`).text(0)
    },
  )
})

$(document).on('click', '.marquerAbsent', function (e) {
  e.preventDefault()
  updateNote($(this).data('note'), 'absent').then(
    (data) => {
      $(`#note_${data}`).text('Absence justifiée')
    },
  )
})

$(document).on('click', '#supprAbsent', function (e) {
  e.preventDefault()
  updateNote($(this).data('note'), 'suppr-absence')
})

let matiereHide = false
$(document).on('click', '#masquerRessourcesSaes', function (e) {
  if (matiereHide) {
    $('.matiere').show()
    matiereHide = false
  } else {
    $('.matiere').hide()
    matiereHide = true
  }
})

function updateNote(id, action) {
  return $.ajax({
    url: Routing.generate('administration_note_corrige_ajax', { note: id, action }),
    method: 'POST',
    success(data) {
      return data
    },
  })
}
