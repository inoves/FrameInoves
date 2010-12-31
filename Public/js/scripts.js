$(document).ready(function(){
	
	/* HEADER POSTERS SLIDER START */
    var divparent = $("#slider")
    var liitem = $("#slider ul#gallery li");
    var i = 0;
	var intHandler;
	var time = 5000;

    liitem.css({ display: 'none' });
    liitem.find("p").css({ display: 'none' });
    $(liitem[0]).css({ display: 'block' });
    $(liitem[0]).find("p").css({ display: 'block' });

	var pagins = $("<ul class='pagins'></ul>");
	divparent.append(pagins);
    liitem.each(function(){
        pagins.append("<li><a href='#' rel='"+i+"'></a></li>");
        i++;
    });
    
	pagins.find("a:first").addClass("active");

    pagins.find("a").click(function(){ paginClick($(this)); return false; });
	
	var interval = function(time){
		intHandler = setInterval(function(){
		    anim();
		}, time);
	}
	
	interval(time);
    
    function paginClick(el){
		var links = $("ul.pagins a");
        links.removeClass("active");
        el.addClass("active");
        var currel = el.attr("rel");
        liitem.find("p").fadeOut()
        liitem.fadeOut(600);
        $(liitem[currel]).fadeIn(600, function(){
            $(liitem[currel]).find("p").fadeIn();
        });
		clearInterval(intHandler);
		interval(time);
    }
    
    function anim(){
		var links = $("ul.pagins a");
        var curlink = $("ul.pagins a.active");
        var currel = parseInt(curlink.attr("rel"));
        links.removeClass("active");
		
		if(currel >= links.length-1){
            currel = -1;
        }else{  }
		
		$(links[currel+1]).addClass("active");
        liitem.find("p").fadeOut(function(){})
        liitem.fadeOut(500);
        $(liitem[currel+1]).fadeIn(500, function(){
            $(liitem[currel+1]).find("p").fadeIn();
        });
		
    }
	/* HEADER POSTERS SLIDER END */
	
	/* DATE SCRIPTS START */
	
	function getdate(){
		var currentTime = new Date();
		$_date = {
			date		: currentTime.getDate(),
			month		: currentTime.getMonth(),
			year		: currentTime.getFullYear(),
			month_names : new Array("jan", "feb", "mar", "abr", "mai", "jun", "jul", "ago", "set", "out", "nov", "dez"),
			divdate		: $("#date"),
			dspan		: $("<span class='date'></span>"),
			mnspan		: $("<span class='month'></span>"),
			yspan		: $("<span class='year'></span>")
		}
		
		$_date.dspan.text($_date.date+' ');
		$_date.mnspan.text($_date.month_names[$_date.month]+' ');
		$_date.yspan.text($_date.year);
		
		$_date.divdate.append($_date.dspan).append($_date.mnspan).append($_date.yspan);
		
	}
	
	function clock(){		
		var currentTime = new Date();
		var $_clock = {
				hours 	: currentTime.getHours(),
				minutes : currentTime.getMinutes(),
				hspan 	: $("<span class='hours'></span>"),
				mspan 	: $("<span class='minutes'></span>"),
				divtime : $("#time")
			}
			
		$_clock.divtime.append($_clock.hspan).append($_clock.mspan);
		
		if($_clock.minutes<=9){
			$_clock.minutes = "0"+$_clock.minutes;
		}
		//$_clock.divtime.find("span").text('');
		
		$_clock.hspan.text($_clock.hours+':');
		$_clock.mspan.text($_clock.minutes);
	}
	
	function updateClock(){	
		var currentTime = new Date();
		var $_clock = {
				hours 	: currentTime.getHours(),
				minutes : currentTime.getMinutes(),
				hspan 	: $("span.hours"),
				mspan 	: $("span.minutes")
			}
		
		if($_clock.minutes<=9){
			$_clock.minutes = "0"+$_clock.minutes;
		}
		
		$_clock.hspan.text($_clock.hours+':');
		$_clock.mspan.text($_clock.minutes);
	}
	
	getdate();
	clock();
	
	setInterval(function(){ updateClock() }, 5000)
	/* DATE SCRIPTS END */
	
	/* MENU START */
	var li = $("#menu ul li");		
	li.stop().hover(function(){
		var elem = $(this),
			parent = elem.parent("ul"),
			child = elem.find(".smenu-c"),
			lipos = elem.position().left,
			childLiW = 0;
		if (child.length) {
			elem.addClass("active");
			child.show()
				 .css({ 
					left: lipos
				 });
		child.find("li").each(function(){
			childLiW = childLiW + $(this).width() + 8;
		})
		child.find("ul").css({ width: childLiW })
			var childpos = child.position().left,
				raz = child.width()-(parent.width()-childpos);
			if(raz>=0) {
				child.css({
					left: parent.width()-child.width()
				});
			}
		}
				
	}, function(){
		var elem = $(this),
			parent = elem.parent("ul"),
			child = elem.find(".smenu-c"),
			lipos = elem.position().left;
		child.hide(1, function(){ li.removeClass("active"); })
	})
	/* MENU END */
	
	/* CUSTOM SELECT START */
	/*var $_select = {
		custom 	 : $("select.custom-select"),
		parent	 : $("select.custom-select").parent("div"),
		ul		 : $("<ul class='select-list' />")
	}
	
	$_select.parent.append($_select.ul);
	var ullist = $("ul.select-list");
	var options;
	var soptions = [];
	for(var i=0; i<=$_select.custom.length-1; i++){
		$($_select.custom[i]).attr('id', 'select'+(i+1));
		options = $($_select.custom[i]).find("option");
		for(var j=0; j<=options.length-1; j++){
			
			$(ullist[i]).append('<li class="">'+$(options[j]).val()+'</li>')
		}
	}*/
	/* CUSTOM SELECT END */
	
	/* FORM TEXT HIDE START */
	swapValue = [];
    $("input:text").each(function(i){
    swapValue[i] = $(this).val();
    $(this).focus(function(){
      if ($(this).val() == swapValue[i]) {
         $(this).val("");
      }
      }).blur(function(){
            if ($.trim($(this).val()) == "") {
            $(this).val(swapValue[i]);
            }
      });
    });
	/* FORM TEXT HIDE END */

	
	$(window).load(function () {
		var transbrd = $("a.transbrd");
		transbrd.each(function(){
			var cur = $(this);
			cur.css({
				opacity: 0.6,
				width: (cur.parent("div").width()-10),
				height: (cur.parent("div").height()-10)	
			})
		})
	});
	
});

