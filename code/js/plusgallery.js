 /*
 * +Gallery Javascript Photo gallery v0.7.2
 * http://plusgallery.net/
 *
 * Copyright 2012, Jeremiah Martin
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html

 */

$(function(){
	pg.init();
});


$.ajaxSetup({ cache: false });
/*
SLIDEFADE
------------------------------------------------------------------------------------------------------*/

/* Custom plugin for a slide/in out animation with a fade - JJM */

(function( $ ){
  $.fn.slideFade = function(speed,callback) {
		 for(var i=0; i<arguments.length; i++)  {
			if( typeof arguments[i] == "number" ) {
				var slideSpeed  = arguments[i];
			}
			else {
				var callBack = arguments[i];
			}
		}
	if(!slideSpeed) {
		var slideSpeed = 500;
	}
		this.animate({
				opacity: 'toggle',
				height: 'toggle'
			}, slideSpeed, 
			function(){
				if( typeof callBack != "function" ) { callBack = function(){} }
				callBack.call(this)
			}
		);
  };
})( jQuery );




var pg = {
	/*user defined Defaults*/
	/*slideDelay: 6000,	integer: delay between slides in milliseconds*/
	/*autoPlay: false, boolean: play slideshow when gallery loads*/
	type: 'google',
	albumTitle: true, //show the album title in single album mode
	imgArray: new Array(),
	titleArray: new Array(),
	albumLimit: 20, //Limit amout of albums to load initially. 
	limit: 30, //Limit of photos to load for gallery / more that 60 is dumb, separate them into different albums
	apiKey: '', //used with Flickr
	
	/*don't touch*/
	t: '', //timer
	idx: 0,
	imgCount: 0,
	imgTotal: 0,
	winWidth: 1024, //resets
	touch: false,
	titleText: '',
	
	
	
	init: function(){
		var _doc = $(document);
		//check for touch device
		if ("ontouchstart" in document.documentElement) {
			window.scrollTo(0, 1);
			pg.touch = true;
		}
		
		pg.winWidth = $(window).width();
		
		pg.getDataAttr();
		pg.writeHTML();
		if(pg.albumId != null){
			//load single Album
			pg.loadSingleAlbum();
		}
		else {
			pg.loadAlbumData();
		}
		
		
		//attach loadGallery to the album links
		_doc.on("click", ".pgalbumlink",function(e){
			e.preventDefault();
			$(this).append('<span class="pgloading"></span>');							 
			var galleryURL = this.href;
			var galleryTitle = $(this).children('span').html();
			pg.loadGallery(galleryURL,galleryTitle);
		});
		
		_doc.on("click", "#pgthumbhome",function(e){
			e.preventDefault();
			$('#pgthumbview').slideFade(1000);
			$('#pgalbums').slideFade(1000);
		});
		
		//attach links load detail image
		_doc.on('click','.pgthumb',function(e){
			e.preventDefault();
			var idx = $('.pgthumb').index(this);
			pg.loadZoom(idx);
		});
		
		
		/*zoom events*/
		
		_doc.on('click','.pgzoomarrow',function(e){
			e.preventDefault();
			var dir = this.rel;
			pg.prevNext(dir);
			return false;
		});
		
		_doc.on('click','.pgzoomclose',function(e){
			e.preventDefault();
			pg.unloadZoom();
		});
		_doc.on("click", "#pgzoomview",function(e){
			e.preventDefault();
			pg.unloadZoom(); 
		});
		
		
		_doc.on("click", "#pgzoomslide",function(){
			pg.unloadZoom();
		});
		
		_doc.on("click", ".pgzoomimg",function(){
			return false
		});
		
		clearTimeout(pg.t);	
	},
	
	
	
	/*--------------------------
	
		get all the user defined
		variables from the HTML element
	
	----------------------------*/
	getDataAttr: function(){
		var pgDiv = $('#plusgallery');
		pgDiv.attr('data-userid')
		//Gallery User Id *required
		var dataAttr = pgDiv.attr('data-userid'); 
		if(dataAttr) {
			pg.userId = dataAttr;
		}
		else {
			alert('You must enter a valid User ID');	
		}
		
		//Gallery Type *required
		dataAttr = pgDiv.attr('data-type');
		if(dataAttr) {
			pg.type = dataAttr;
		}
		else {
			alert('You must enter a data type.');	
		}
		
		
		//Limit on the amount photos per gallery 
		dataAttr = pgDiv.attr('data-limit');
		if(dataAttr) {
			pg.limit = dataAttr;
		}
		
		//Limit on the amount albums
		dataAttr = pgDiv.attr('data-album-limit');
		if(dataAttr) {
			pg.albumLimit = dataAttr;
		}
		
		//Api key - used with Flickr
		dataAttr = pgDiv.attr('data-api-key');
		if(dataAttr) {
			pg.apiKey = dataAttr;
		}
		
		
		
		
		dataAttr = pgDiv.attr('data-album-id');
		if(dataAttr) {
			pg.albumId = dataAttr;
			
			//show hide the album title if we are in single gallery mode
			titleAttr = pgDiv.attr('data-album-title');
			if(titleAttr == 'true') {
				pg.albumTitle = true;
			} else {
				pg.albumTitle = false;
			}
		}
		else {
			pg.albumTitle = true;
			pg.albumId = null;
		}
		
		dataAttr = pgDiv.attr('data-credit');
		if(dataAttr == 'false') {
			pg.credit = false;
		}
		else {
			pg.credit = true;
		}
		
		
		//not used
		
		/*
		dataAttr = pgDiv.attr('data-excludeprofile');
		if(dataAttr == 'false') {
			pg.excludeProfile = false;
		} else {
			pg.excludeProfile = true;
		}
		 */
	},
	
	
	
	/*--------------------------
	
		set up the initial HTML
	
	----------------------------*/
	writeHTML: function(){
		if(pg.touch){
			var touchClass = 'touch';
			$('#plusgallery').addClass('touch');
		}
		else {
			var touchClass = 'no-touch';
			$('#plusgallery').addClass('no-touch');
		}
		
		
		$('#plusgallery').append(
			'<ul id="pgalbums" class="clearfix"></ul>' + 
			'<div id="pgthumbview">' + 
				'<ul id="pgthumbs" class="clearfix"></ul>' + 
			'</div>'
		);
		$('body').prepend(
			'<div id="pgzoomview" class="pg ' + touchClass + '">' + 
				'<a href="#" rel="previous" id="pgzoomclose" title="Close">Close</a>' + 
				'<a href="#" rel="previous" id="pgprevious" class="pgzoomarrow" title="previous">Previous</a>' + 
				'<a href="#" rel="next" id="pgnext" class="pgzoomarrow" title="Next">Next</a>' + 
				'<div id="pgzoomscroll">' + 
					'<ul id="pgzoom"></ul>' + 
				'</div>' + 
			'</div>'
			);
		
		$('#plusgallery').addClass('pg');
				
		if(pg.albumTitle == true) {
			$('#pgthumbview').prepend('<ul id="pgthumbcrumbs" class="clearfix"><li id="pgthumbhome">&laquo;</li></ul>')
		}
	},
	
	
	/*--------------------------
	
		Load up Album Data JSON 
		before Albums
	
	----------------------------*/
	loadAlbumData: function() {
		switch(pg.type)
		{
		case 'google':
			var albumURL = 'https://picasaweb.google.com/data/feed/base/user/' + pg.userId + '?alt=json&kind=album&hl=en_US&max-results=' + pg.albumLimit + '&callback=?';	
			break;
		case 'flickr':
			var albumURL = 'http://api.flickr.com/services/rest/?&method=flickr.photosets.getList&api_key=' + pg.apiKey + '&user_id=' + pg.userId + '&format=json&jsoncallback=?';	
			break;
		case 'facebook':
			var albumURL = 'http://graph.facebook.com/' + pg.userId + '/albums&limit=' + pg.albumLimit + '&callback=?';	
			break;
		default:
			alert('Please define a gallery type.');
		}
		
		
		$.getJSON(albumURL,function(json) {
				$('#plusgallery').addClass('loaded');
				
				switch(pg.type)
				{
				//have to load differently for for google/facebook/flickr
				case 'google':
				
					var objPath = json.feed.entry,
							albumTotal = objPath.length;
							
					if(albumTotal > pg.albumLimit) {
						albumTotal = pg.albumLimit;
					}
				
					
					if(albumTotal > 0){
						$.each(objPath,function(i,obj){	
							//obj is entry
							if(i < albumTotal){
								var galleryTitle = obj.title.$t,
										galleryImage = obj.media$group.media$thumbnail[0].url,
										galleryJSON = obj.link[0].href;
										
										galleryImage = galleryImage.replace('s160','s210');
							
								pg.loadAlbums(galleryTitle,galleryImage,galleryJSON,i);
							}
	
						});
					} 
					else { //else if albumTotal == 0
						alert('There are either no results for albums with this user ID or there was an error loading the data. \n' + galleryJSON);
					}
					
				break;
				case 'flickr':
					var objPath = json.photosets.photoset,
							albumTotal = objPath.length;
							
					if(albumTotal > pg.albumLimit) {
						albumTotal = pg.albumLimit;
					}
							
					if(albumTotal > 0 ) {
						$.each(objPath,function(i,obj){	
							//obj is entry
							if(i < albumTotal){
								var galleryTitle = obj.title._content,
										galleryImage = 'http://farm' + obj.farm + '.staticflickr.com/' + obj.server + '/' + obj.primary + '_' + obj.secret + '_n.jpg',
										galleryJSON = 'http://api.flickr.com/services/rest/?&method=flickr.photosets.getPhotos&api_key=' + pg.apiKey + '&photoset_id=' + obj.id + '=&format=json&jsoncallback=?';
		
								pg.loadAlbums(galleryTitle,galleryImage,galleryJSON);
							}
						});
					} 
					else { //else if albumTotal == 0
						alert('There are either no results for albums with this user ID or there was an error loading the data. \n' + galleryJSON);
					}
					
				break;
				case 'facebook':
					var objPath = json.data,
							albumTotal = objPath.length;
							
					if(albumTotal > pg.albumLimit) {
						albumTotal = pg.albumLimit;
					}
							
					if(albumTotal > 0) {
					/*if(pg.excludeProfile == true){ 
						albumTotal--; //remove one if we are excluding the profile
					}*/
					
						$.each(objPath,function(i,obj){	
							if(i < albumTotal){											
								var galleryTitle = obj.name;
								var galleryJSON = 'http://graph.facebook.com/' + obj.id + '/photos';
								
								//if(pg.excludeProfile == true && galleryTitle != 'Profile Pictures'){ //exclude Profile Pictures from Facebook TODO
										var galleryImage = 'http://graph.facebook.com/' + obj.id + '/picture?type=album';	
										pg.loadAlbums(galleryTitle,galleryImage,galleryJSON);
								//}
							}
							
						});
					} 
					else { //else albumTotal == 0 	
						alert('There are either no results for albums with this user ID or there was an error loading the data. \n' + albumURL);
					}
					
					break;
				}

		});
	},
		
	
	
	/*--------------------------
	
		Load all albums to the page
	
	----------------------------*/
	loadAlbums: function(galleryTitle,galleryImage,galleryJSON) {
		
		if(pg.type == 'facebook' || pg.type == 'flickr') {
		 var imgHTML = 	'<img src="/images/plusgallery/210.png" style="background-image: url(' + galleryImage + ');" title="' + galleryTitle + '" title="' + galleryTitle + '" class="pgalbumimg">';	
		}
		else {
			var imgHTML = '<img src="' + galleryImage + '" title="' + galleryTitle + '" title="' + galleryTitle + '" class="pgalbumimg">';	
		}
				
		$('#pgalbums').append(
			'<li class="pgalbumthumb">' + 
      	'<a href="' + galleryJSON + '" class="pgalbumlink first">' + imgHTML + '<span class="pgalbumtitle"><b>' + galleryTitle + '</b></span></a>' + 
        '<a href="' + galleryJSON + '" class="pgalbumlink second">' + imgHTML + '</a>' + 
        '<a href="' + galleryJSON + '" class="pgalbumlink third">' + imgHTML + '</a>' + 
      	'<img src="/images/plusgallery/square.gif" class="spacer" >' + 
			'</li>'
		);
			
	
	}, //End loadAlbums
	
	
	/*--------------------------
	
		Load all the images within
		a specific gallery
	
	----------------------------*/
	
	loadSingleAlbum:function(){
		
		switch(pg.type)
		{
		case 'google':
			var url = 'https://picasaweb.google.com/data/feed/base/user/' + pg.userId + '/albumid/' + pg.albumId + '?alt=json&hl=en_US';
			break;
		case 'flickr':
			var url = 'http://api.flickr.com/services/rest/?&method=flickr.photosets.getPhotos&api_key=' + pg.apiKey + '&photoset_id=' + pg.albumId + '=&format=json&jsoncallback=?';
			break;
		case 'facebook':
			var url = 'http://graph.facebook.com/' + pg.albumId + '/photos';
			break;
		}
		
		pg.loadGallery(url);
		$('#plusgallery').addClass('loaded');
		$('#pgthumbhome').hide();
		
	},
	
	/*--------------------------
	
		Load all the images within
		a specific gallery
	
	----------------------------*/
	loadGallery: function(url,title){
		//console.log('url:'+  url);
		pg.imgArray = [];
		pg.titleArray = [];
		$('#pgzoom').empty();
															
		$.ajax({
			url: url,
			cache: false,
			dataType: "jsonp",
			success: function(json){
				
				$('.crumbtitle').remove();
				$('#pgthumbs').empty();
				
				$('#pgthumbcrumbs').append('<li class="crumbtitle">' + title + '</li>');
			
				switch(pg.type)
				{
				case 'google':
					var objPath = json.feed.entry;	
					break;
				case 'flickr':
					var objPath = json.photoset.photo;	
					break;
				case 'facebook':
					var objPath = json.data;		
					break;
				}
				
				
			
				pg.imgTotal = objPath.length;
				//limit the results
				if(pg.limit < pg.imgTotal){
					pg.imgTotal = pg.limit;
				} 
				
				if(pg.imgTotal == 0) {
					alert('Please check your photo permissions,\nor make sure there are photos in this gallery.');
				}
				
				var thumbsLoaded = 0;
				
				if(pg.winWidth > 1100) {
					 var zoomWidth = 1024;
					 var flickrImgExt = '_b';
					 
				} else if(pg.winWidth > 620) {
					 var zoomWidth = 768;
					 var flickrImgExt = '_b';
				} else {
					var zoomWidth = 540;
					var flickrImgExt = '_z';
				}
				
				$.each(objPath,function(i,obj){
					//limit the results
					
					if(i < pg.limit) {
						switch(pg.type)
						{
						case 'google':
							var imgTitle = obj.title.$t;
							var imgSrc = obj.media$group.media$content[0].url;
							var lastSlash = imgSrc.lastIndexOf('/');
							var imgSrcSubString =imgSrc.substring(lastSlash);
							
							//show the max width image 1024 in this case
							imgSrc = imgSrc.replace(imgSrcSubString, '/s' + zoomWidth + imgSrcSubString);
							
							var imgTh = obj.media$group.media$thumbnail[1].url;
									imgTh = imgTh.replace('s144','s160-c');
							var imgBg = '';
							break;
						case 'flickr':
							var imgTitle = obj.title;
							var imgSrc = 'http://farm' + obj.farm + '.staticflickr.com/' + obj.server + '/' + obj.id + '_' + obj.secret + flickrImgExt + '.jpg';
							var imgTh = 'http://farm' + obj.farm + '.staticflickr.com/' + obj.server + '/' + obj.id + '_' + obj.secret + '_q.jpg';
							var imgBg = '';
							break;
						case 'facebook':
							var imgTitle = obj.name;
							var imgSrc = obj.images[1].source;
							var imgTh = '/images/plusgallery/210.png';
							var imgBg = ' style="background: url(' + obj.images[3].source + ') no-repeat 50% 50%; background-size: cover;"';
							break;
						}
						
						if(!imgTitle) {
							var imgTitle = '';
						} 
								
						pg.imgArray[i] = imgSrc;
						pg.titleArray[i] = imgTitle;	
						
						$('#pgthumbs').append('<li class="pgthumb"><a href="' + imgSrc + '"><img src="' + imgTh + '" id="pgthumbimg' + i + '" class="pgthumbimg" alt="' + imgTitle + '" title="' + imgTitle + '"' + imgBg + '></a></li>');
						
						//check to make sure all the images are loaded and if so show the thumbs
						$('#pgthumbimg' + i).load(function(){
							thumbsLoaded++;
							if(thumbsLoaded == pg.imgTotal) {
								$('#pgalbums').slideFade(1000,function(){
								$('.pgalbumthumb .pgloading').remove();								
							});
							$('#pgthumbview').slideFade(1000);
							}
					});
					} //end if(i < pg.limit)
				});
			}
		});
	}, //End loadGallery
	
	zoomIdx: null, //the zoom index
	zoomImagesLoaded: [],
	zoomScrollDir: null,
	zoomScrollLeft: null,
	loadZoom: function(idx){
		pg.zoomIdx = idx;
		pg.winWidth = $(window).width();	
		var pgZoomView = $('#pgzoomview');
		var pgZoomScroll = $('#pgzoomscroll');
		var pgPrevious = $('#pgprevious');
		var pgNext = $('#pgnext');
		var pgZoom = $('#pgzoom');
		var pgZoomHTML = '';
		var totalImages = pg.imgArray.length;
		pgZoomView.addClass('fixed');
		
		//show/hide the prev/next links
		if(idx == 0) {
			pgPrevious.hide();	
		}
		
		if(idx == totalImages - 1) {
			pgNext.hide();	
		}
		
		//load the slideshow
		//pgZoomView.fadeIn(function(){});

		var pgzoomWidth = pg.imgArray.length * pg.winWidth;
		$('#pgzoom').width(pgzoomWidth);
		
		var scrollLeftInt = parseInt(idx * pg.winWidth);
		
		//$(window).on('resize',pg.resizeZoom);

			
		pgZoomView.fadeIn(function(){
			//this has gotta come in after the fade or iOS blows up.	
			
			$(window).on('resize',pg.resizeZoom);
			
			$.each(pg.imgArray,function(i){	
				pgZoomHTML = pgZoomHTML  + '<li class="pgzoomslide loading" id="pgzoomslide' + i + '" style="width: ' + pg.winWidth + 'px;"><img src="/images/plusgallery/square.gif" class="pgzoomspacer"><span class="pgzoomcaption">' + pg.titleArray[i] + '</span></li>';																	
				//no preload version: pgZoomHTML = pgZoomHTML  + '<li class="pgzoomslide" id="pgzoomslide' + i + '" style="width: ' + pg.winWidth + 'px;"><img src="' + pg.imgArray[idx] + '" class="pgzoomspacer"><span class="pgzoomcaption">' + pg.titleArray[i] + '</span></li>';																	

				if(i + 1 == pg.imgArray.length) {
					//at the end of the loop
						$('#pgzoom').html(pgZoomHTML);
						
						pg.zoomKeyPress();
						$('#pgzoomscroll').scrollLeft(scrollLeftInt);
						pg.zoomScrollLeft = scrollLeftInt; 
						pg.loadZoomImg(idx);
						pg.zoomScroll();
						//load siblings
						if((idx - 1) >= 0){
						pg.loadZoomImg(idx - 1); 
						}
						
						if((idx + 1) < pg.imgArray.length){
							pg.loadZoomImg(idx + 1); 
						}
					}													
				});
			});
	},
	
	
	loadZoomImg:function(idx){
		if($('#pgzoomimg' + idx).length == 0){
		$('#pgzoomslide' + idx + ' .pgzoomspacer').after('<img src="' + pg.imgArray[idx] + '" data-src="' + pg.imgArray[idx] + '" title="' + pg.titleArray[idx] + '" alt="' + pg.titleArray[idx] + '" id="pgzoomimg' + idx + '" class="pgzoomimg">');
		}
	},
	
	zoomScroll:function(){
		var pgPrevious = $('#pgprevious'),
				pgNext = $('#pgnext'),
				scrollTimeout,
				canLoadZoom = true;
				

		$('#pgzoomscroll').on('scroll',function(){
			
			currentScrollLeft = $(this).scrollLeft();
			if(canLoadZoom == true) {
				canLoadZoom = false;
				scrollTimeout = setTimeout(function(){
					
					if(currentScrollLeft == 0){
						pgPrevious.fadeOut();
					}
					else {
						pgPrevious.fadeIn();
						
					}	
					
					if(currentScrollLeft >= (pg.imgTotal - 1) * pg.winWidth){
					pgNext.fadeOut();
					}
					else {
						pgNext.fadeIn();
					}
					
					/*console.log ('currentScrollLeft: ' + currentScrollLeft);
					console.log ('pg.zoomScrollLeft: ' + pg.zoomScrollLeft);*/
					
					if(currentScrollLeft % pg.zoomScrollLeft > 20){
						
						pg.zoomScrollLeft = currentScrollLeft;
						var currentIdx = pg.zoomScrollLeft / pg.winWidth;
						
						var currentIdxCeil = Math.ceil(currentIdx);
						var currentIdxFloor = Math.floor(currentIdx);
						
						//Lazy load siblings on scroll.
						if(!pg.zoomImagesLoaded[currentIdxCeil]) {
							pg.loadZoomImg(currentIdxCeil);
						}
						if(!pg.zoomImagesLoaded[currentIdxFloor]){
							pg.loadZoomImg(currentIdxFloor);
						}	
					}
					canLoadZoom = true;
						
				},200);
			}
			
			
		});	
	
	},
	
	zoomKeyPress: function(){
		$(document).on('keyup','body',function(e){
			if(e.which == 27){
				pg.unloadZoom();
			}
			else
			if(e.which == 37){
				pg.prevNext('previous');
			}
			else
			if(e.which == 39){
				pg.prevNext('next');
			}
		});
	},
	
	resizeZoom: function(){
		pg.winWidth = $(window).width();
		var pgzoomWidth = pg.imgArray.length * pg.winWidth;
		$('#pgzoom').width(pgzoomWidth);
		$('.pgzoomslide').width(pg.winWidth);
		
		var scrollLeftInt = parseInt(pg.zoomIdx * pg.winWidth);
		
		$('#pgzoomscroll').scrollLeft(scrollLeftInt);
	},
	
	unloadZoom: function(){
		$(document).off('keyup','body');
		$(window).off('resize',pg.resizeZoom);
		$('#pgzoomscroll').off('scroll');
		$('#pgzoomview').fadeOut(function(){
			$('#pgzoom').empty();
			$('#pgzoomview').off('keyup');
			$('#pgzoomview').removeClass('fixed');
		});
			
	},
	
	prevNext: function(dir){
		var currentIdx = $('#pgzoomscroll').scrollLeft() / pg.winWidth;
		
		if(dir == "previous"){
			pg.zoomIdx = Math.round(currentIdx)  - 1;
		}
		else {
			pg.zoomIdx = Math.round(currentIdx) + 1;
		}
		
		var newScrollLeft = pg.zoomIdx * pg.winWidth;
		
		$('#pgzoomscroll').stop().animate({scrollLeft:newScrollLeft});
	}
}





















