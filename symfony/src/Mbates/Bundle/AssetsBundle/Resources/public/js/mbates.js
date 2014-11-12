$(document).ready(function() {
	$('.row-link').click(function(){
		document.location.href=$(this).attr('data-url');
	});

	$('.modal').on('hidden.bs.modal', function(event) {
		$(this).removeData('bs.modal');
		$(this).removeClass('fv-modal-stack');
		$('body').data('fv_open_modals', $('body').data('fv_open_modals')-1);
	});


	$('.modal').on('shown.bs.modal', function(event) {
		// keep track of the number of open modals
		if(typeof($('body').data('fv_open_modals'))=='undefined')
		{
			$('body').data('fv_open_modals', 0);
		}

		// if the z-index of this modal has been set, ignore.
		if($(this).hasClass('fv-modal-stack'))
		{
			return;	
		}

		$(this).addClass('fv-modal-stack');
		$('body').data('fv_open_modals', $('body').data('fv_open_modals')+1);
		$(this).css('z-index', 1040+(10*$('body').data('fv_open_modals')));
		$('.modal-backdrop')
			.not('.fv-modal-stack')
			.css('z-index', 1039+(10*$('body').data('fv_open_modals')));
		$('.modal-backdrop')
			.not('fv-modal-stack')
			.addClass('fv-modal-stack');
	});

	//call viewInitializationFunction function from views, if it exists
	if(typeof viewInitializationFunction == 'function') {
		viewInitializationFunction();
	}
});

var pageLoading;
pageLoading = pageLoading || (function () {
	var pageLoadingDiv = $('<div id="page-loading-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="page-loading-title" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="page-loading-title"></h4></div><div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></div></div></div></div>');
	return {
		show: function(loadingText) {
			pageLoadingDiv.find('.page-loading-title').text(loadingText);
			pageLoadingDiv.modal();
		},
		hide: function () {
			pageLoadingDiv.modal('hide');
		}
	};
})();

// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());