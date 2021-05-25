$(document).ready(function(){
    
    function redirectPage() {
		window.location = linkLocation;
	}

    function trnsline() {
		$('body').append('<div id="tpage"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div>')
	}   
    
    function trnslines() {
		$('body').append('<div id="tpage"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div>')
	}  
    
    function trnslinesto() {
		$('body').append('<div id="tpage"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div><div id="tpage-to"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div>')
	} 
    
    function trnslinesfo() {
		$('body').append('<div id="tpage"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div><div id="tpage-tot"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div><div id="tpage-three"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div><div id="tpage-four"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div>')
	}
    
    function trnscube() {
		$('body').append('<div id="tpage"><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div><div class="element"></div></div>')
	}
    
    var trns = 'trans-'+$('body').attr('data-transition');
    num = $('body').attr('data-transition');

    if (num <= 2){
        trnsline();
    }   
        else {
            
        if (num == 3){
            trnscube();
        }
        
        if (num == 4){
            trnscube();
            h = $('#tpage > div').width()/5;
            $('#tpage>div').css({'height': h+'px'});
        }
        
        if (num == 5){
            trnscube();
            h = $('#tpage > div').width()/5;
            $('#tpage>div').css({'height': h+'px'});
        }
        
        if (num == 6){
            trnsline();
        }
        
        if (num == 7){
            trnsline();
        }
        
        if (num == 8){
            trnsline();
        }
        
        if (num == 9){
            trnsline();
        }
        
        if (num == 10){
            trnscube();
            h = $('#tpage > div').width();
            $('#tpage>div').css({'height': h+'px'});
        }     
            
        if (num == 11){
            trnslinesto();
            h = $('#tpage > div').width()/10;
            $('#tpage>div').append('<div style="height:'+h+'px;bottom: -'+h/2+'px" class="circle"></div>');
            $('#tpage-to>div').append('<div style="height:'+h+'px;bottom: -'+h/2+'px" class="circle"></div>');
            $('#tpage-to').addClass(trns+'-out');
        }     
            
        if (num == 12){
            trnslinesto();
            h = $('#tpage').height()/10;
            $('#tpage>div').append('<div style="width:'+h+'px;right: -'+h/2+'px" class="circle"></div>');
            $('#tpage-to>div').append('<div style="width:'+h+'px;right: -'+h/2+'px" class="circle"></div>');
            $('#tpage-to').addClass(trns+'-out');
        }     
            
        if (num == 13){
            trnslinesfo();
            h = $('#tpage').height()/10;
            $('#tpage>div').append('<div style="width:'+h+'px;right: -'+h/2+'px" class="circle"></div>');
            $('#tpage-tot>div').append('<div style="width:'+h+'px;right: -'+h/2+'px" class="circle"></div>');
            $('#tpage-three>div').append('<div style="width:'+h+'px;right: -'+h/2+'px" class="circle"></div>');
            $('#tpage-four>div').append('<div style="width:'+h+'px;right: -'+h/2+'px" class="circle"></div>');
            $('#tpage-tot').addClass(trns+'-out');
            $('#tpage-three').addClass(trns+'-out');
            $('#tpage-four').addClass(trns+'-out');
        }     
            
        if (num == 14){
            $('body').addClass(trns+'-out').css({'overflow': 'hidden'});
            setTimeout(function(){
                $('body').css({'overflow': 'auto'});
            },500);
        }     
            
        if (num == 15){
            $('body').addClass(trns+'-out').css({'overflow': 'hidden'});
            setTimeout(function(){
                $('body').css({'overflow': 'auto'});
            },500);
        }    
            
        if (num == 16){
            $('body').addClass(trns+'-out').css({'overflow': 'hidden'});
            setTimeout(function(){
                $('body').css({'overflow': 'auto'});
            },500);
        }  
            
        if (num == 17){
            $('body').addClass(trns+'-out').css({'overflow': 'hidden'});
            setTimeout(function(){
                $('body').css({'overflow': 'auto'});
            },500);
        }  
            
        if (num == 18){
            $('body').addClass(trns+'-out').css({'overflow': 'hidden'}).append('<div class="transparency"></div>');
            setTimeout(function(){
                $('body').css({'overflow': 'auto'});
            },500);
        }  
            
        if (num == 19){
            $('body').addClass(trns+'-out').css({'overflow': 'hidden'}).append('<div class="transparency"></div>');
            setTimeout(function(){
                $('body').css({'overflow': 'auto'});
            },500);
        }  
            
        if (num == 20){
            $('body').addClass(trns+'-out').css({'overflow': 'hidden'}).append('<div class="transparency"></div>');
            setTimeout(function(){
                $('body').css({'overflow': 'auto'});
            },500);
        }
    }
    
    $('#tpage').addClass(trns+'-out');
    setTimeout(function(){
                $('#tpage').css({'display': 'none'});
                $('#tpage-to').css({'display': 'none'});
                $('#tpage-tot').css({'display': 'none'});
                $('#tpage-three').css({'display': 'none'});
                $('#tpage-four').css({'display': 'none'});
                $('.transparency').css({'display': 'none'});
            },1000);
    
    $('a').click(function(){
        event.preventDefault();
		linkLocation = this.href;
            $('#tpage').removeClass(trns+'-out').css({'display': 'block'});
            $('#tpage-to').removeClass(trns+'-out').css({'display': 'block'});
            $('#tpage-tot').removeClass(trns+'-out').css({'display': 'block'});
            $('#tpage-three').removeClass(trns+'-out').css({'display': 'block'});
            $('#tpage-four').removeClass(trns+'-out').css({'display': 'block'});
            $('.transparency').removeClass(trns+'-out').css({'display': 'block'});
            $('#tpage').addClass(trns+'-in');
            $('#tpage-to').addClass(trns+'-in');
            $('#tpage-tot').addClass(trns+'-in');
            $('#tpage-three').addClass(trns+'-in');
            $('#tpage-four').addClass(trns+'-in');
            if (num == 14){
                $('body').removeClass(trns+'-out').css({'overflow': 'hidden'});
                $('body').addClass(trns+'-in');
            }
            if (num == 15){
                $('body').removeClass(trns+'-out').css({'overflow': 'hidden'});
                $('body').addClass(trns+'-in');
            }
            if (num == 16){
                $('body').removeClass(trns+'-out').css({'overflow': 'hidden'});
                $('body').addClass(trns+'-in');
            }
            if (num == 17){
                $('body').removeClass(trns+'-out').css({'overflow': 'hidden'});
                $('body').addClass(trns+'-in');
            }
            if (num == 18){
                $('body').removeClass(trns+'-out').css({'overflow': 'hidden'});
                $('body').addClass(trns+'-in');
            }
            if (num == 19){
                $('body').removeClass(trns+'-out').css({'overflow': 'hidden'});
                $('body').addClass(trns+'-in');
            }
            if (num == 20){
                $('body').removeClass(trns+'-out').css({'overflow': 'hidden'});
                $('body').addClass(trns+'-in');
            }
        setTimeout(function(){
            redirectPage();
        },1200);
    });
    
});