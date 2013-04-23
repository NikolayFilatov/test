$(document).ready(function(){

    open_color=false;
    function findX(el){
        var curX=0;
        if(el.offsetParent){
            while(el.offsetParent){
                curX+=el.offsetLeft;
                el=el.offsetParent;
            }
        }
        else if(el.x) curX+=el.x;
        return curX;
    }
    function findY(el){
        var curY=0;
        if(el.offsetParent){
            while(el.offsetParent){
                curY+=el.offsetTop;
                el=el.offsetParent;
            }
        }
        else if(el.y) curY+=el.y;
        return curY;
    }
    function getColor(x,y){
        var dec_r;
        var dec_g;
        var dec_b;
        if(y<22){
            dec_g=(256-y*12)/128;
            dec_r=0;
            dec_b=2;
        }
        else if(y>21&&y<43){
            dec_g=0;
            dec_r=(y*12-256)/128;
            dec_b=2;
        }
        else if(y>42&&y<65){
            dec_r=2;
            dec_b=(768-y*12)/128;
            dec_g=0;
        }
        else if(y>64&&y<86){
            dec_b=0;
            dec_g=(y*12-768)/128;
            dec_r=2;
        }
        else if(y>85&&y<107){
            dec_g=2;
            dec_r=(1280-y*12)/128;
            dec_b=0;
        }
        else if(y>106){
            dec_r=0;
            dec_b=(y*12-1280)/128;
            dec_g=2;
        }
        red=Number(Math.abs(Math.round(255-x*dec_r))).toString(16);
        green=Number(Math.abs(Math.round(255-x*dec_g))).toString(16);
        blue=Number(Math.abs(Math.round(255-x*dec_b))).toString(16);
        if(red.length<2) red="0"+red;
        if(green.length<2) green="0"+green;
        if(blue.length<2) blue="0"+blue;
        return '#'+red+green+blue;
    }
    function chColor(x,y,k){
        var dec_r;
        var dec_g;
        var dec_b;
        if(y<22){
            dec_g=(256-y*12)/128;
            dec_r=0;
            dec_b=2;
        }
        else if(y>21&&y<43){
            dec_g=0;
            dec_r=(y*12-256)/128;
            dec_b=2;
        }
        else if(y>42&&y<65){
            dec_r=2;
            dec_b=(768-y*12)/128;
            dec_g=0;
        }
        else if(y>64&&y<86){
            dec_b=0;
            dec_g=(y*12-768)/128;
            dec_r=2;
        }
        else if(y>85&&y<107){
            dec_g=2;
            dec_r=(1280-y*12)/128;
            dec_b=0;
        }
        else if(y>106){
            dec_r=0;
            dec_b=(y*12-1280)/128;
            dec_g=2;
        }
        red=Number(Math.abs(Math.round((255-x*dec_r)*k))).toString(16);
        green=Number(Math.abs(Math.round((255-x*dec_g)*k))).toString(16);
        blue=Number(Math.abs(Math.round((255-x*dec_b)*k))).toString(16);
        if(red.length<2) red="0"+red;
        if(green.length<2) green="0"+green;
        if(blue.length<2) blue="0"+blue;
        return '#'+red+green+blue;
    }
    mmousedown=false;
    bmousedown=false;
    $(document).ready(function(){
        $(".gradus").mousedown(function(){
            mmousedown=true;
        });
        $(".gradus").mouseup(function(){
            mmousedown=false;
        });
        $(".gradus").mousemove(function(e){
            if(!mmousedown) return;
            var x=e.pageX-findX(this);
            var y=e.pageY-findY(this);
            if(x>127 || x<0 || y>127 || y<0){
                mmousedown=false;
                return;
            }
            var color=getColor(x,y);
            var field=$(this).attr("id");
            $("#"+field+"_krest").css("top",y-7);
            $("#"+field+"_krest").css("left",x-7);
            $("[name="+field+"]").val(color);
            $("#"+field+"_pre").css("background",color);
            $("#"+field+"_pic").css("background",color);
            $("#"+field+"_line").css("top",0);
        });
        $(".gradus").click(function(e){
            var x=e.pageX-findX(this);
            var y=e.pageY-findY(this);
            if(x>127 || x<0 || y>127 || y<0){
                mmousedown=false;
                return;
            }
            var color=getColor(x,y);
            var field=$(this).attr("id");
            $("#"+field+"_krest").animate({top:y-7, left:x-7},"fast");
            $("[name="+field+"]").val(color);
            $("#"+field+"_pre").css("background",color);
            $("#"+field+"_pic").css("background",color);
            $("#"+field+"_line").css("top",0);
        });
        $(".ppic").mouseenter(function(e){
            if(open_color) return;
            open_color=true;
            var len=$(this).attr("id");
            len=len.length-4;
            var id=$(this).attr("id").substr(0,len);
            $(this).css("z-index","-1");
            $("#"+id+"_main").css("position","absolute");
            $("#"+id+"_main").css("left",e.pageX-100);
            $("#"+id+"_main").css("width","215px");
            $("#"+id+"_main").css("height","130px");
            $("#"+id+"_main").css("padding","5px");
            $("#"+id+"_main").css("z-index","0");
            $("#"+id+"_main").animate({opacity:1},"slow");
            open_color=false;
        });
        $(".all_for_clr").mouseleave(function(){
            if(open_color) return;
            open_color=true;
            $(this).animate({opacity:0},"slow",function(){
                $(this).css("position","relative");
                $(this).css("left","0");
                $(this).css("width","0");
                $(this).css("height","0");
                $(this).css("padding","0");
                $(this).css("z-index","-1");
                $(".ppic").css("z-index","5");
                open_color=false;
            });
        });
        $(".brightness").mousedown(function(){
            bmousedown=true;
        });
        $(".brightness").mouseup(function(){
            bmousedown=false;
        });
        $(".brightness").mousemove(function(e){
            if(!bmousedown) return;
            var y=e.pageY-findY(this);
            var x=e.pageX-findX(this);
            if(x>19 || x<0 || y>127 || y<0){
                bmousedown=false;
                return;
            }
            var k=(127-y)/127;
            var len=$(this).attr("id");
            len=len.length-3;
            var id=$(this).attr("id").substr(0,len);
            var spec=document.getElementById(id);
            var krest=document.getElementById(id+"_krest");
            var x_color=findX(krest)+7-findX(spec);
            var y_color=findY(krest)+7-findY(spec);
            var color=chColor(x_color,y_color,k);
            $("#"+id+"_line").css("top",y);
            $("[name="+id+"]").val(color);
            $("#"+id+"_pre").css("background",color);
            $("#"+id+"_pic").css("background",color);
        });
        $(".brightness").click(function(e){
            var y=e.pageY-findY(this);
            var x=e.pageX-findX(this);
            if(x>19 || x<0 || y>127 || y<0){
                bmousedown=false;
                return;
            }
            var k=(127-y)/127;
            var len=$(this).attr("id");
            len=len.length-3;
            var id=$(this).attr("id").substr(0,len);
            var spec=document.getElementById(id);
            var krest=document.getElementById(id+"_krest");
            var x_color=findX(krest)+7-findX(spec);
            var y_color=findY(krest)+7-findY(spec);
            var color=chColor(x_color,y_color,k);
            $("#"+id+"_line").animate({top:y},"fast");
            $("[name="+id+"]").val(color);
            $("#"+id+"_pre").css("background",color);
            $("#"+id+"_pic").css("background",color);
        });
    });
});