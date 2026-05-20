(function () {
	'use strict';
	if ( ! window.esprodouroIns ) return;

	function init() {
		var forms = document.querySelectorAll( '.espins__form' );
		forms.forEach( function ( form ) { bind( form ); } );
	}

	function bind( form ) {
		var err  = form.querySelector( '.espins__err' );
		var btn  = form.querySelector( '.espins__btn' );
		var wrap = form.closest( '.espins-wrap' );

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			hideErr();

			var data    = new FormData( form );
			var nome    = ( data.get( 'nome' ) || '' ).trim();
			var email   = ( data.get( 'email' ) || '' ).trim();
			var tel     = ( data.get( 'telefone' ) || '' ).replace( /\s+/g, '' );
			var encNome = ( data.get( 'enc_nome' ) || '' ).trim();
			var encTel  = ( data.get( 'enc_telefone' ) || '' ).replace( /\s+/g, '' );

			if ( ! nome )                                       return showErr( 'O nome do aluno é obrigatório.' );
			if ( ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( email ) ) return showErr( 'Introduz um email válido.' );
			if ( ! validPhone( tel ) )                          return showErr( 'Número do aluno inválido (9 dígitos a começar por 9).' );
			if ( ! encNome )                                    return showErr( 'O nome do encarregado de educação é obrigatório.' );
			if ( ! validPhone( encTel ) )                       return showErr( 'Número do encarregado inválido (9 dígitos a começar por 9).' );
			if ( ! form.querySelector( '[name="c_enc"]' ).checked )  return showErr( 'É necessária a autorização do encarregado.' );
			if ( ! form.querySelector( '[name="c_rgpd"]' ).checked ) return showErr( 'É necessário aceitar o contacto por WhatsApp.' );

			var originalLabel = btn.textContent;
			btn.disabled    = true;
			btn.textContent = esprodouroIns.i18n.submitting;

			fetch( esprodouroIns.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: data
			} )
			.then( function ( res ) {
				return res.json().then( function ( body ) {
					return { ok: res.ok, body: body };
				} );
			} )
			.then( function ( r ) {
				if ( r.body && r.body.success ) {
					renderSuccess( r.body.data || {} );
				} else {
					var msg = ( r.body && r.body.data && r.body.data.message ) || esprodouroIns.i18n.generic_error;
					showErr( msg );
					btn.disabled    = false;
					btn.textContent = originalLabel;
				}
			} )
			.catch( function () {
				showErr( esprodouroIns.i18n.generic_error );
				btn.disabled    = false;
				btn.textContent = originalLabel;
			} );
		} );

		function showErr( m ) {
			if ( ! err ) return;
			err.textContent  = m;
			err.style.display = 'block';
		}
		function hideErr() {
			if ( ! err ) return;
			err.style.display = 'none';
		}
		function validPhone( p ) {
			return /^9\d{8}$/.test( p ) || /^\+?3519\d{8}$/.test( p );
		}
		function renderSuccess( payload ) {
			if ( ! wrap ) return;
			var name = payload.first_name ? escapeHtml( payload.first_name ) : 'aluno';
			wrap.outerHTML = '<div class="espins espins-wrap espins-success">' +
				'<div class="espins-success__c">&#10003;</div>' +
				'<h3>Feito, <em>' + name + '</em>!</h3>' +
				'<p>A tua inscrição foi registada. Vamos entrar em contacto contigo brevemente.</p>' +
				'</div>';
		}
		function escapeHtml( s ) {
			return String( s ).replace( /[&<>"']/g, function ( c ) {
				return ( { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' } )[ c ];
			} );
		}
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
})();
