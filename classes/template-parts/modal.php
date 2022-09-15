<?php
/**
 * Template part for displaying Modal Template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 * @NOTE - Requires $modal variable to be set
 * @NOTE - Requires id btn_lms_modal
 */

$modal = '<div id="btn_lms_modal" class="btn_lms_modal micromodal-slide" aria-hidden="true">';
	$modal .= '<div class="btn_lms_modal__overlay" tabindex="-1" data-micromodal-close>';
		$modal .= '<div class="btn_lms_modal__container" role="dialog" aria-modal="true" aria-labelledby="btn_lms_modal-title">';
			$modal .= '<header class="btn_lms_modal__header">';
				$modal .= '<h2 class="btn_lms_modal__title"></h2>';
				$modal .= '<button class="btn_lms_modal__close" aria-label="'. __('Close notificaton', 'btn-lms') .'" data-micromodal-close>';
				$modal .= '</button>';
			$modal .= '</header>';
			$modal .= '<main class="btn_lms_modal__content"></main>';
		$modal .= '</div>';
	$modal .= '</div>';
$modal .= '</div>';