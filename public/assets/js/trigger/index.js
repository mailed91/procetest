//.:: Create vars ::.//
    var mySpreadsheet;
    var request;
//.:: Date Converting .:://
    function ints(value) {
        if(value == null){
            return 0;
        }else{
            var vals = value.toString();
            var result;
            if(vals.indexOf(',') != -1){
                result = vals.replace(/\,/g, '');
            }else{
                result = vals;
            }
            result = parseFloat(result);
            result = Math.round(parseInt(result));
            return result;
        }
    }
    function gregorian_to_jalali(gy,gm,gd){
        var g_d_m,jy,jm,jd,gy2,days;
        g_d_m=[0,31,59,90,120,151,181,212,243,273,304,334];
        if(gy > 1600){
            jy=979;
            gy-=1600;
        }else{
            jy=0;
            gy-=621;
        }
        gy2=(gm > 2)?(gy+1):gy;
        days=(365*gy) +(parseInt((gy2+3)/4)) -(parseInt((gy2+99)/100)) +(parseInt((gy2+399)/400)) -80 +gd +g_d_m[gm-1];
        jy+=33*(parseInt(days/12053));
        days%=12053;
        jy+=4*(parseInt(days/1461));
        days%=1461;
        if(days > 365){
            jy+=parseInt((days-1)/365);
            days=(days-1)%365;
        }
        jm=(days < 186)?1+parseInt(days/31):7+parseInt((days-186)/30);
        jd=1+((days < 186)?(days%31):((days-186)%30));
        return [jy,jm,jd];
    }
    function jalali_to_gregorian(jy,jm,jd){
        var sal_a,gy,gm,gd,days,v;
        if(jy > 979){
            gy=1600;
            jy-=979;
        }else{
            gy=621;
        }
        days=(365*jy) +((parseInt(jy/33))*8) +(parseInt(((jy%33)+3)/4)) +78 +jd +((jm<7)?(jm-1)*31:((jm-7)*30)+186);
        gy+=400*(parseInt(days/146097));
        days%=146097;
        if(days > 36524){
            gy+=100*(parseInt(--days/36524));
            days%=36524;
            if(days >= 365)days++;
        }
        gy+=4*(parseInt(days/1461));
        days%=1461;
        if(days > 365){
            gy+=parseInt((days-1)/365);
            days=(days-1)%365;
        }
        gd=days+1;
        sal_a=[0,31,((gy%4===0 && gy%100!==0) || (gy%400===0))?29:28,31,30,31,30,31,31,30,31,30,31];
        for(gm=0;gm<13;gm++){
            v=sal_a[gm];
            if(gd <= v)break;
            gd-=v;
        }
        return [gy,gm,gd];
    }
    function g2j(date){
        var gy = ints(date.split(" ")[0].split("-")[0]);
        var gm = ints(date.split(" ")[0].split("-")[1]);
        var gd = ints(date.split(" ")[0].split("-")[2]);
        var jdate = gregorian_to_jalali(gy,gm,gd);
        return jdate[0]+'/'+jdate[1]+'/'+jdate[2];
    }
    function j2g(date){
        var jy = ints(date.split("/")[0]);
        var jm = ints(date.split("/")[1]);
        var jd = ints(date.split("/")[2]);
        var jdate = jalali_to_gregorian(jy,jm,jd);
        return jdate[0]+'-'+jdate[1]+'-'+jdate[2];
    }
    function Today() {
        var today = new Date();
        var month = today.getMonth()+1;
        var day = today.getDate();
        var year = today.getFullYear();
        var today_jalali = gregorian_to_jalali(year,month,day);
        var today_jalali_full = today_jalali[0]+'/'+today_jalali[1]+'/'+today_jalali[2];
        return today_jalali_full;
    }
    $("input[name='S_DATE']").val(Today());
    $("input[name='E_DATE']").val(Today());
//.:: Ajax controles .:://
    function Request(url,info) {
        var responses = "";
        if (request) {
            request.abort();
        }
        var Data = new FormData();
        Data.append("Data",info);

        // waiting();

        request = $.ajax({
            url: "/"+url,
            type: 'POST',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function (requests) {
                return requests.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            data: Data
        });

        request.done(function (response, textStatus, jqXHR){
            return true;
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            alert(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });

        request.always(function () {
            // $('.waiting').fadeOut(500, function(){ $(this).remove();});
        });
    }
    //.:: Requests .:://
//.:: Developing Software Functions ::. //
    function save(){
        var data = mySpreadsheet.getJson();
        Request("save",JSON.stringify([data,j2g($("input[name='S_DATE']").val())+' 00:00:00',j2g($("input[name='E_DATE']").val())+' 00:00:00']));
        request.done(function (response){
            console.log(response);
        });
    }
    function load(){
        var data = mySpreadsheet.getJson();
        Request("load",JSON.stringify([j2g($("input[name='S_DATE']").val())+' 00:00:00',j2g($("input[name='E_DATE']").val())+' 00:00:00']));
        request.done(function (response){
            console.log(response);
            mySpreadsheet.setData(response);
        });
    }
    function price_table() {
        Request("get_data",1);
        request.done(function(response){
            console.log(response);
            var data = [{}];
            var Mats = response[0];
            var Groups = response[1];
            var Grades = response[2];
            mySpreadsheet = jexcel(document.getElementById('table'), {
                data:data,
                columns: response,
                columnSorting:true,
                columnDrag:true,
                tableOverflow: true,
                tableWidth: "100%",
                tableHeight:"250px",
                editable:true,
                search:false,
                filters:false,
            });
        });
    }
    price_table();
