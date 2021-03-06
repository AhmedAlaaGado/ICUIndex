/**
 * Created by Gado on 6/28/2017.
 */

function edit_row(id)
{
    var total_beds=document.getElementById("total_beds_val"+id).innerHTML;
    var freebeds=document.getElementById("freebeds_val"+id).innerHTML;

    document.getElementById("freebeds_val"+id).innerHTML="<input type='number' id='freebeds_text"+id+"' min='0' max='"+total_beds+"' value='"+freebeds+"'>";

    document.getElementById("edit_button"+id).style.display="none";
    document.getElementById("save_button"+id).style.display="inline";
}

function save_row(id)
{
    var total_beds=document.getElementById("total_beds_val"+id).innerHTML;
    var freebeds=document.getElementById("freebeds_text"+id).value;

    if(freebeds < 0 || freebeds > Number(total_beds))
    {
        swal({
            title: 'خطأ',
            text: 'تأكد من أن قيمة الأسرة المتاحة لا يتعدى عدد إجمالي الأسرة ولا يقل عن الصفر',
            type: 'error'
        })

    }else {
        var data = {
            edit_row: 'edit_row',
            dep_id: id,
            free_beds: freebeds
        };

        $.ajax
        ({
            type: 'post',
            url: 'admin/updateFB.php',
            data: data,
            success: function (response) {
                if (response == "success") {
                    document.getElementById("freebeds_val" + id).innerHTML = freebeds;
                    document.getElementById("edit_button" + id).style.display = "inline";
                    document.getElementById("save_button" + id).style.display = "none";
                    swal({
                        title: 'عظيم!',
                        text: 'تم التحديث بنجاح!',
                        type: 'success',
                        timer: 4000
                    })
                }
            }
        });
    }
}

function refreshDep()
{
    $.ajax
    ({
        type:'post',
        url:'admin/refreshDepartment-ar.php',
        data:{
            refresh:'refresh'
        },
        success:function(whatigot) {
            //alert('Document is ready');
            $('#refreshDep').html(whatigot);
        }
    });
}

function refreshAddUser()
{
    $.ajax
    ({
        type:'post',
        url:'admin/refreshAddUser-ar.php',
        data:{
            refresh:'refresh'
        },
        success:function(whatigot) {
            //alert('Document is ready');
            $('#refreshAddUser').html(whatigot);
            $("select").chosen({rtl: true,disable_search_threshold: 10,no_results_text:  "للأسف, لم يتم العثور على" ,search_contains:true,width: "100%"});

        }
    });
}

function refreshUsers()
{
    //if ($.fn.DataTable.isDataTable("#users")) {
    //    $('#users').DataTable().clear().destroy();
    //    $('#refreshUsers').html("");
    //}
    //alert("refreshh user");
    $.ajax
    ({
        type:'post',
        url:'admin/refreshUsers.php',
        data:{
            refresh:'refresh'
        },
        success:function(whatigot) {
            //alert(whatigot);
            //$('#users').clear().remove();

            $('#refreshUsers').html(whatigot).find('table').DataTable({
                "language": {
                    "sProcessing":   "جارٍ التحميل...",
                    "sLengthMenu":   "أظهر _MENU_ مدخلات",
                    "sZeroRecords":  "لم يعثر على أية سجلات",
                    "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix":  "",
                    "sSearch":       "ابحث",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "الأول",
                        "sPrevious": "السابق",
                        "sNext":     "التالي",
                        "sLast":     "الأخير"
                    }
                }
            });
        }
    });

}



/* -------------------- Departments Operations -------------------- */

function edit_dep(id)
{
    var totalbeds=document.getElementById("totalbeds_val"+id).innerHTML;
    var name=document.getElementById("name_val"+id).innerHTML;

    document.getElementById("totalbeds_val"+id).innerHTML="<input type='number' id='totalbeds_text"+id+"' min='1' value='"+totalbeds+"'>";
    document.getElementById("name_val"+id).innerHTML="<input type='text' id='name_text"+id+"' value='"+name+"'>";

    document.getElementById("edit_but"+id).style.display="none";
    document.getElementById("save_but"+id).style.display="inline";
}

function save_dep(id)
{
    var letters = /^[a-zA-Zأ-ي\s]+$/;
    var totalbeds=document.getElementById("totalbeds_text"+id).value;
    var name=document.getElementById("name_text"+id).value;

    if(name == null || name== "" || !(letters.test(name)) || totalbeds == null || totalbeds == "" || Number(totalbeds) < 1){
        alert("يجب عليك إدخال اسم صالح للقسم وإجمالي عدد الأسرة");

    }else {
        var data = {
            edit_row: 'edit_row',
            dep_id: id,
            total_beds: totalbeds,
            name: name
        };

        $.ajax
        ({
            type: 'post',
            url: 'admin/updateDepartment.php',
            data: data,
            success: function (response) {
                if (response == "success") {
                    document.getElementById("totalbeds_val" + id).innerHTML = totalbeds;
                    document.getElementById("name_val" + id).innerHTML = name;
                    document.getElementById("edit_but" + id).style.display = "inline";
                    document.getElementById("save_but" + id).style.display = "none";

                    refreshDep();
                    //alert("updated");
                    swal({
                        title: 'عظيم!',
                        text: 'تم التحديث بنجاح!',
                        type: 'success',
                        timer: 1500
                    })
                } else {
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error',
                        timer: 1500
                    })
                }
            }
        });
    }
}

function delete_dep(id)
{
    if (confirm("هل أنت متأكد؟ \nأنك تريد حذف بيانات هذا القسم") == true) {
        $.ajax
        ({
            type:'post',
            url:'admin/deleteDepartment.php',
            data:{
                delete_row:'delete_row',
                id:id
            },
            success:function(response) {
                if(response=="success")
                {
                    var row=document.getElementById("row"+id);
                    row.parentNode.removeChild(row);

                    refreshDep();
                    swal({
                        title:  'عظيم!',
                        text: 'تم الحذف بنجاح!',
                        type: 'success',
                        timer: 1500
                    })

                }else{
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error',
                        timer: 1500
                    })
                }
            }
        });
    } else {
        alert("تم الإلغاء \nالقسم بأمان, لم يتغير شيء");
    }

    /*
     swal({
     title: 'هل أنت متأكد؟',
     text: "You want to Delete This Department Data!",
     type: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Yes, Delete!',
     cancelButtonText: 'No, cancel!',
     confirmButtonClass: 'btn btn-success',
     cancelButtonClass: 'btn btn-danger',
     buttonsStyling: false
     }).then(function () {

     $.ajax
     ({
     type:'post',
     url:'admin/deleteDepartment.php',
     data:{
     delete_row:'delete_row',
     id:id
     },
     success:function(response) {
     if(response=="success")
     {
     var row=document.getElementById("row"+id);
     row.parentNode.removeChild(row);

     refreshDep();
     swal({
     title:  'عظيم!',
     text: 'تم الحذف بنجاح!',
     type: 'success',
     timer: 1500
     })

     }else{
     swal({
     title: 'خطأ',
     text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
     type: 'error',
     timer: 1500
     })
     }
     }
     });

     }, function (dismiss) {
     // dismiss can be 'cancel', 'overlay',
     // 'close', and 'timer'
     if (dismiss === 'cancel') {

     swal({
     title: 'تم الإلغاء',
     text: 'Department is safe :) Nothing changed',
     type: 'error'
     })

     }
     })
     */

}

function add_dep()
{
    var letters = /^[a-zA-Zأ-ي\s]+$/;
    var name=document.getElementById("new_name").value;
    var totalbeds=document.getElementById("new_totalbeds").value;

    if(name == null || name== "" || !(letters.test(name)) || totalbeds == null || totalbeds == "" || Number(totalbeds) < 1){
        alert("يجب عليك إدخال اسم صالح للقسم وإجمالي عدد الأسرة");

    }else{
        $.ajax
        ({
            type:'post',
            url:'admin/addDepartment.php',
            data:{
                insert_row:'insert_row',
                name_val:name,
                totalbeds_val:totalbeds
            },
            success:function(response) {
                if(response!="")
                {
                    var id=response;
                    var table=document.getElementById("user_table");
                    var table_len=(table.rows.length)-1;
                    var row = table.insertRow(table_len).outerHTML="<tr id='row"+id+"'><td id='name_val"+id+"'>"+name+"</td><td id='totalbeds_val"+id+"'>"+totalbeds+"</td><td align='center' width='36%'><input type='button' class='edit_button' id='edit_but"+id+"' value='تعديل' onclick='edit_dep("+id+");'/><input type='button' class='save_button' id='save_but"+id+"' value='حفظ' onclick='save_dep("+id+");' style='display: none'/><input type='button' class='delete_button special' id='delete_but"+id+"' value='حذف' onclick='delete_dep("+id+");'/></td></tr>";

                    document.getElementById("new_name").value="";
                    document.getElementById("new_totalbeds").value="";

                    refreshDep();
                    swal({
                        title:  'عظيم!',
                        text: "تمت الإضافة بنجاح!",
                        type: 'success',
                        timer: 1500
                    })
                }else{
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error'
                    })
                }
            }
        });
    }

}

/* -------------------- End of Departments Operations -------------------- */

/* -------------------- Hospital Operations -------------------- */

function edit_hos(id)
{
    var name=document.getElementById("hosname_val"+id).innerHTML;
    var phone=document.getElementById("hosphone_val"+id).innerHTML;
    var address=document.getElementById("hosaddress_val"+id).innerHTML;
    var city_id=$("#city_id_val"+id).html();
    var selectCity = $('#new_city').html();

    document.getElementById("hosname_val"+id).innerHTML="<input type='text' id='hosname_text"+id+"' value='"+name+"'>";
    document.getElementById("hosphone_val"+id).innerHTML="<input type='text' id='hosphone_text"+id+"' value='"+phone+"'>";
    document.getElementById("hosaddress_val"+id).innerHTML="<input type='text' id='hosaddress_text"+id+"' value='"+address+"'>";
    $("#city_val"+id).html("<select id='city_text"+id+"'>"+selectCity+"</select>");
    $('#city_text'+id).val(city_id);
    $("select").chosen({rtl: true,disable_search_threshold: 10,no_results_text:  "للأسف, لم يتم العثور على" ,search_contains:true,width: "100%"});

    document.getElementById("edit_hos"+id).style.display="none";
    document.getElementById("save_hos"+id).style.display="inline";
}

function save_hos(id)
{
    var name=document.getElementById("hosname_text"+id).value;
    var phone=document.getElementById("hosphone_text"+id).value;
    var address=document.getElementById("hosaddress_text"+id).value;
    var city_id=document.getElementById("city_text"+id).value;
    var city = $("#city_text"+id+" option[value='"+city_id+"']").text();

    var data = {
        submit:'submit',
        source:'Sadmin',
        hos_id:id,
        name:name,
        phone:phone,
        address:address,
        city_id:city_id
    };

    $.ajax
    ({
        type:'post',
        url:'admin/updateHospital.php',
        data: data,
        success:function(response) {
            //alert('server side response'+response);
            if(response == "success")
            {
                document.getElementById("hosname_val"+id).innerHTML=name;
                document.getElementById("hosphone_val"+id).innerHTML=phone;
                document.getElementById("hosaddress_val"+id).innerHTML=address;
                document.getElementById("city_val"+id).innerHTML= "<a hidden='' id='city_id_val"+id+"'>"+city_id+"</a>"+city;

                document.getElementById("edit_hos"+id).style.display="inline";
                document.getElementById("save_hos"+id).style.display="none";

                refreshAddUser();
                //alert("updated");
                swal({
                    title:  'عظيم!',
                    text:  'تم التحديث بنجاح!',
                    type: 'success',
                    timer: 1500
                })
            }else{

                swal({
                    title: 'خطأ',
                    text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                    type: 'error',
                    timer: 1500
                })
            }
        }
    });
}

function delete_hos(id)
{
    if (confirm("هل أنت متأكد؟ \nأنك تريد حذف بيانات هذا المشفى!") == true) {
        $.ajax
        ({
            type:'post',
            url:'admin/deleteHospital.php',
            data:{
                delete_hos:'delete_hos',
                id:id
            },
            success:function(response) {
                if(response=="success")
                {
                    var row=document.getElementById("hosrow"+id);
                    row.parentNode.removeChild(row);

                    refreshAddUser();
                    swal({
                        title:  'عظيم!',
                        text: 'تم الحذف بنجاح!',
                        type: 'success',
                        timer: 1500
                    })

                }else{
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error',
                        timer: 1500
                    })
                }
            }
        });
    } else {
        alert("تم الإلغاء \nالمشفى بأمان, لم يتغير شيء");
    }


}

function add_hos()
{
    var name=document.getElementById("new_hosname").value;
    var phone=document.getElementById("new_hosphone").value;
    var address=document.getElementById("new_hosaddress").value;
    var city_id=document.getElementById("new_city").value;
    var city = $("#new_city").find("option[value='" + city_id + "']").text();

    if(name == null || name== ""){
        alert("يجب عليك على الأقل أن تدخل اسم المشفى");

    }else{
        $.ajax
        ({
            type:'post',
            url:'admin/addHospital.php',
            data:{
                insert_hos:'insert_hos',
                name:name,
                phone:phone,
                address:address,
                city_id:city_id

            },
            success:function(response) {
                if(response!="")
                {
                    var id=response;
                    var table=document.getElementById("hospitalsTable");
                    var table_len=(table.rows.length)-1;
                    var row = table.insertRow(table_len).outerHTML="<tr id='hosrow"+id+"'>" +
                    "<td><h3 id='hosname_val"+id+"'>"+name+"</h3></td> " +
                    "<td><h3 id='hosphone_val"+id+"'>"+phone+"</h3> " +
                    "<td><h3 id='hosaddress_val"+id+"'>"+address+"</h3> " +
                    "<td><h3 id='city_val"+id+"'><a hidden='' id='city_id_val"+id+"'>"+city_id+"</a>"+city+"</h3></td> " +
                    "<td align='center' width='37%'> " +
                    "<input type='button' class='edit_button' id='edit_hos"+id+"' value='تعديل' onclick='edit_hos("+id+");'> " +
                    "<input type='button' class='save_button' id='save_hos"+id+"' value='حفظ' onclick='save_hos("+id+");' style='display: none'> " +
                    "<input type='button' class='delete_button special' id='delete_hos"+id+"' value='حذف' onclick='delete_hos("+id+");'></td></tr>";

                    document.getElementById("new_hosname").value="";
                    document.getElementById("new_hosphone").value="";
                    document.getElementById("new_hosaddress").value="";
                    $("#new_city").val('').trigger("chosen:updated");

                    refreshAddUser();
                    swal({
                        title:  'عظيم!',
                        text: "تمت الإضافة بنجاح!",
                        type: 'success',
                        timer: 1500
                    })
                }else{
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error'
                    })
                }
            }
        });
    }

}

/* -------------------- End of Hospital Operations -------------------- */

/* -------------------- Feedback Operations -------------------- */
function delete_fb(id)
{
    if (confirm("هل أنت متأكد؟ \nأنك تريد حذف بيانات هذه الرسالة") == true) {
        $.ajax
        ({
            type:'post',
            url:'admin/deleteFeedback.php',
            data:{
                delete_fb:'delete_fb',
                id:id
            },
            success:function(response) {
                //alert('server side response: '+response);
                if(response=="success")
                {
                    var row=document.getElementById("fbrow"+id);
                    var message = $('#addedmessage'+id);
                    row.parentNode.removeChild(row);
                    var td = message.parent();
                    td.closest('tr').remove();

                    swal({
                        title:  'عظيم!',
                        text: 'تم الحذف بنجاح!',
                        type: 'success',
                        timer: 1500
                    })

                }else{
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error',
                        timer: 1500
                    })
                }
            }
        });
    } else {
        alert("تم الإلغاء \nالرسالة بأمان, لم يتغير شيء");
    }


}

/* -------------------- End of Feedback Operations -------------------- */

/* -------------------- User Operations -------------------- */

function edit_user(id)
{
    //var hospital=document.getElementById("hospital_val"+id).innerHTML;
    //var hos_id=document.getElementById("hos_id_val"+id).innerHTML;
    var hos_id=$("#hos_id_val"+id).html();
    var ug_id=$("#ug_id_val"+id).html();
    //var usergroup=document.getElementById("usergroup_val"+id).innerHTML;
    var active=document.getElementById("active_val"+id).innerHTML;
    var name=document.getElementById("name_val"+id).innerHTML;

    var selectHos = $('#user_hospital').html();
    var selectUG = $('#user_group').html();
    var selectAct = $('#user_active').html();
    //alert(selectHos);
    //document.getElementById("hospital_val"+id).innerHTML="<input type='text' id='hospital_text"+id+"' value='"+hospital+"'>";
    $("#hospital_val"+id).html("<select id='hospital_text"+id+"'>"+selectHos+"</select>");
    $('#hospital_text'+id).val(hos_id);
    $("#usergroup_val"+id).html("<select id='usergroup_text"+id+"'>"+selectUG+"</select>");
    $('#usergroup_text'+id).val(ug_id);
    $("#active_val"+id).html("<select id='active_text"+id+"'>"+selectAct+"</select>");
    $('#active_text'+id).val(active);
    //document.getElementById("usergroup_val"+id).innerHTML="<input type='text' id='usergroup_text"+id+"' value='"+usergroup+"'>";
    //document.getElementById("active_val"+id).innerHTML="<input type='text' id='active_text"+id+"' value='"+active+"'>";
    document.getElementById("name_val"+id).innerHTML="<input type='text' id='name_text"+id+"' value='"+name+"'>";

    $("select").chosen({rtl: true,disable_search_threshold: 10,no_results_text:  "للأسف, لم يتم العثور على" ,search_contains:true,width: "100%"});

    document.getElementById("edit_button"+id).style.display="none";
    document.getElementById("save_button"+id).style.display="inline";
}

function save_user(id)
{
    var hos_id=document.getElementById("hospital_text"+id).value;
    var hospital = $("#hospital_text"+id+" option[value='"+hos_id+"']").text();
    var ug_id=document.getElementById("usergroup_text"+id).value;
    var usergroup = $("#usergroup_text"+id+" option[value='"+ug_id+"']").text();
    var active=document.getElementById("active_text"+id).value;
    var name=document.getElementById("name_text"+id).value;


    if( ug_id == null || ug_id == ""){
        swal({
            title: 'خطأ',
            text:"يجب عليك اختيار نوع مستخدم",
            type: 'error'
        })

    }else if((hos_id == null || hos_id == "") && ug_id == 2 ){
        swal({
            title: 'خطأ',
            text:"يجب عليك اختيار مشفى",
            type: 'error'
        })
    }else if ((hos_id) && ug_id == 1 ){
        swal({
            title: 'خطأ',
            text: "مدير الموقع لا يمكن أن يكون مدير مشفى في نفس الوقت",
            type: 'error'
        })
    }else{
        var data = {
            edit_user:'edit_user',
            user_id:id,
            hos_id:hos_id,
            ug_id:ug_id,
            active:active,
            name:name
        };
        $.ajax
        ({
            type: 'post',
            url: 'admin/updateuser.php',
            data: data,
            success: function (response) {
                if (response == "success") {
                    document.getElementById("hospital_val" + id).innerHTML = "<a hidden='' id='hos_id_val" + id + "'>" + hos_id + "</a>" + hospital;
                    document.getElementById("usergroup_val" + id).innerHTML = "<a hidden='' id='ug_id_val" + id + "'>" + ug_id + "</a>" + usergroup;
                    document.getElementById("active_val" + id).innerHTML = active;
                    document.getElementById("name_val" + id).innerHTML = name;
                    document.getElementById("edit_button" + id).style.display = "inline";
                    document.getElementById("save_button" + id).style.display = "none";

                    //refreshUsers();
                    //alert("updated");
                    swal({
                        title: 'عظيم!',
                        text: 'تم التحديث بنجاح!',
                        type: 'success'
                    })
                } else {
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error'
                    })
                }
            }
        });
    }
}

function delete_user(id)
{

    swal({
        title: 'هل أنت متأكد؟',
        text: "أنك تريد حذف بيانات هذا المستخدم!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم, احذف!',
        cancelButtonText: 'لا, إلغاء!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {
        $.ajax
        ({
            type:'post',
            url:'admin/deleteUser.php',
            data:{
                delete_user:'delete_user',
                id:id
            },
            success:function(response) {
                if(response=="success")
                {
                    var row=document.getElementById("row"+id);
                    row.parentNode.removeChild(row);
                    //refreshUsers();
                    swal({
                        title:  'عظيم!',
                        text: 'تم الحذف بنجاح!',
                        type: 'success'
                    })

                }else{
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error'
                    })
                }
            }
        });
    }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
            swal(
                'تم الإلغاء',
                'المستخدم بأمان, لم يتغير شيء',
                'error'
            )
        }
    })
}



function add_user()
{
    var hos_id=document.getElementById("user_hospital").value;
    var hospital = $("#user_hospital").find("option[value='" + hos_id + "']").text();
    var ug_id=document.getElementById("user_group").value;
    var usergroup = $("#user_group").find("option[value='" + ug_id + "']").text();
    var name=document.getElementById("user_name").value;
    var email=document.getElementById("user_email").value;
    var phone=document.getElementById("user_phone").value;
    var password=document.getElementById("user_password").value;
    var active=document.getElementById("user_active").value;

    if(password == null || password== "" || email == null || email == ""){
        swal({
            title: 'خطأ',
            text:"يجب عليك إدخال البريد الإلكتروني للمستخدم وكلمة السر",
            type: 'error'
        })

    }else if( ug_id == null || ug_id == ""){
        swal({
            title: 'خطأ',
            text:"يجب عليك اختيار نوع مستخدم",
            type: 'error'
        })

    }else if((hos_id == null || hos_id == "") && ug_id == 2 ){
        swal({
            title: 'خطأ',
            text:"يجب عليك اختيار مشفى",
            type: 'error'
        })
    }else if ((hos_id) && ug_id == 1 ){
        swal({
            title: 'خطأ',
            text: "مدير الموقع لا يمكن أن يكون مدير مشفى في نفس الوقت",
            type: 'error'
        })
    }else{

        $.ajax
        ({
            type:'post',
            url:'admin/addUser.php',
            data:{
                addUser:'addUser',
                name:name,
                hos_id:hos_id,
                ug_id:ug_id,
                email:email,
                phone:phone,
                password:password,
                active:active

            },
            success:function(response) {
                if(response!="")
                {
                    var id=response;
                    var table=document.getElementById("users");
                    var table_len=(table.rows.length)-1;
                    var row = table.insertRow(table_len).outerHTML="<tr id='row"+id+"'>" +
                    "<td><h3 id='hospital_val"+id+"'><a hidden='' id='hos_id_val"+id+"'>"+hos_id+"</a>"+hospital+"</h3></td>" +
                    "<td><h3 id='usergroup_val"+id+"'><a hidden='' id='ug_id_val"+id+"'>"+ug_id+"</a>"+usergroup+"</h3></td>" +
                    "<td><h3 id='name_val"+id+"'>"+name+"</h3></td>" +
                    "<td><h3 id='email_val"+id+"'>"+email+"</h3></td>" +
                    "<td><h3 id='phone_val"+id+"'>"+phone+"</h3></td>" +
                    "<td><h3 id='address_val"+id+"'></h3></td>" +
                    "<td><h3 id='active_val"+id+"'>"+active+"</h3></td>" +
                    "<td width='17%'><input type='button' class='edit_button' id='edit_button"+id+"' value='تعديل' onclick='edit_user("+id+");'/>"+
                    "<input type='button' class='save_button' id='save_button"+id+"' value='حفظ' onclick='save_user("+id+");' style='display: none'/>" +
                    "<input type='button' class='delete_button special' id='delete_button"+id+"' value='حذف' onclick='delete_user("+id+");'/>" +
                    "</td></tr>";


                    $("#user_hospital").val('').trigger("chosen:updated");
                    $("#user_group").val('').trigger("chosen:updated");
                    document.getElementById("user_name").value="";
                    document.getElementById("user_email").value="";
                    document.getElementById("user_phone").value="";
                    document.getElementById("user_password").value="";
                    $("#user_active").val('').trigger("chosen:updated");

                    //refreshUsers();
                    swal({
                        title:  'عظيم!',
                        text: "تمت الإضافة بنجاح!",
                        type: 'success'
                    })
                }else{
                    swal({
                        title: 'خطأ',
                        text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                        type: 'error'
                    })
                }
            }
        });
    }

}

/* -------------------- End of User Operations -------------------- */

/* Formatting function for row details - modify as you need */
function format ( message , id ) {
    // `d` is the original data object for the row
    return '<table id="addedmessage'+id+'" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
    '<tr>'+
    '<td>الرسالة:</td>'+
    '<td>'+message+'</td>'+
    '</tr>'+
    '</table>';
}

/* -------------------- begin of DOM -------------------- */

$(function() {
    //alert('Document is ready');

    $('#users').DataTable({
        "language": {
            "sProcessing":   "جارٍ التحميل...",
            "sLengthMenu":   "أظهر _MENU_ مدخلات",
            "sZeroRecords":  "لم يعثر على أية سجلات",
            "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix":  "",
            "sSearch":       "ابحث",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "الأول",
                "sPrevious": "السابق",
                "sNext":     "التالي",
                "sLast":     "الأخير"
            }
        },
        "sPaginationType": "full_numbers",
        "order": [[2, 'asc']]
    });
    $('#hospitalsTable').DataTable({
        "language": {
            "sProcessing":   "جارٍ التحميل...",
            "sLengthMenu":   "أظهر _MENU_ مدخلات",
            "sZeroRecords":  "لم يعثر على أية سجلات",
            "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix":  "",
            "sSearch":       "ابحث",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "الأول",
                "sPrevious": "السابق",
                "sNext":     "التالي",
                "sLast":     "الأخير"
            }
        },
        "sPaginationType": "full_numbers"
    });
    var table= $('#feedbackTable').DataTable({
        "language": {
            "sProcessing":   "جارٍ التحميل...",
            "sLengthMenu":   "أظهر _MENU_ مدخلات",
            "sZeroRecords":  "لم يعثر على أية سجلات",
            "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix":  "",
            "sSearch":       "ابحث",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "الأول",
                "sPrevious": "السابق",
                "sNext":     "التالي",
                "sLast":     "الأخير"
            }
        },
        "sPaginationType": "full_numbers",
        "order": [[1, 'asc']]

    });

    // Add event listener for opening and closing details
    $('#feedbackTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format($(this).data('message'),$(this).data('id')) ).show();
            tr.addClass('shown');
        }
    } );

    $("select").chosen({rtl: true,disable_search_threshold: 10,no_results_text:  "للأسف, لم يتم العثور على" ,search_contains:true,width: "100%"});
    //submit the edit values of profile admin work
    $('#profileEdit').on("click",function() {

        var validatemail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var interedemail = $('#premail').val();
        var email = interedemail.replace(/\s+/g, '');
        if(email == "" || email == null || !(validatemail.test(email)))
        {
            alert("Please enter a valid email address")
            alert("برجاء إدخال عنوان بريد إلكتروني صالح");
        }
        else{

            swal({
                title: 'هل أنت متأكد؟',
                text: "أنك تريد تحديث بياناتك الشخصية!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم, حدث!',
                cancelButtonText: 'لا, إلغاء!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function () {
                var name = $('#prname').val();
                var opass = $('#propass').val();
                var npass = $('#prnpass').val();
                var cpass = $('#prcpass').val();
                var address = $('#praddress').val();
                var phone = $('#prphone').val();
                var sec_q = $('#prsec_q').val();
                var sec_q_a = $('#prsec_q_a').val();


                if(npass != cpass)
                {
                    swal(
                        'خطأ',
                        'كلمة السر الجديدة لا تتوافق مع تأكيد كلمة السر ',
                        'error'
                    )

                }
                else if((opass != null || opass != "") && npass == cpass &&  (npass != null || npass != "" || cpass != null || cpass != ""))
                {
                    var data = {
                        submit:'submit',
                        prname: name,
                        premail: email,
                        propass: opass,
                        prnpass: npass,
                        praddress: address,
                        prphone: phone,
                        prsec_q: sec_q,
                        prsec_q_a: sec_q_a
                    };

                    //alert('You picked: ' + user_id);
                    $.ajax
                    ({
                        type:'post',
                        url:'admin/updateProfile.php',
                        data: data,
                        success:function(response) {
                            //alert('Server-side response: ' + response);
                            if(response == "success")
                            {
                                swal(
                                     'عظيم!',
                                     'تم التحديث بنجاح!',
                                    'success'
                                )
                            }else if(response == "errorpass")
                            {
                                swal(
                                    'خطأ',
                                    'كلمة السر القديمة خاطئة, أعد إدخال كلمة السر ',
                                    'error'
                                )
                            }else if(response == "erroremptypass")
                            {
                                swal(
                                    'خطأ',
                                    'يجب عليك إدخال كلمة سر جديدة ',
                                    'error'
                                )
                            }else if(response == "erroremptyopass")
                            {
                                swal(
                                    'خطأ',
                                    'يجب عليك إدخال كلمة السر القديمة',
                                    'error'
                                )
                            }else
                            {
                                swal(
                                    'خطأ',
                                    'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                                    'error'
                                )

                            }
                        }
                    });

                }else if((opass != null || opass != "") && (npass == null || npass == "" || cpass == null || cpass == ""))
                {
                    swal(
                        'خطأ',
                        'يجب عليك إدخال كلمة السر الجديدة',
                        'error'
                    )
                }
            }, function (dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {
                    swal(
                        'تم الإلغاء',
                        'بياناتك الشخصية بأمان, لم يتغير شيء',
                        'error'
                    )
                }
            })}

    }); //END submit click event


    //submit the edit values of hospital  work
    $('#hospitalEdit').on("submit",function() {

        swal({
            title: 'هل أنت متأكد؟',
            text: "أنك تريد تحديث بيانات المشفى!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم, حدث!',
            cancelButtonText: 'لا, إلغاء!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function () {

            //alert('You picked: ' + user_id);
            $.ajax
            ({
                type:'post',
                url:'admin/updateHospital.php',
                data: {submit:'submit',
                    source:"Hadmin",
                    data: $("#hospitalEdit").serialize()
                },
                success:function(response) {
                    //alert('Server-side response: ' + response);
                    if(response == "success")
                    {
                        swal(
                             'عظيم!',
                             'تم التحديث بنجاح!',
                            'success'
                        )
                    }else
                    {
                        swal(
                            'خطأ',
                            'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                            'error'
                        )

                    }
                }
            });

        }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
                swal(
                    'تم الإلغاء',
                    'بيانات المشفى بأمان, لم يتغير شيء',
                    'error'
                )
            }
        })

    }); //END submit click event

    $('#feedback').on("submit", function (e) {

        var name = $("#feedback input[name=name]").val();
        var email = $("#feedback input[name=email]").val();
        var message = $("#feedback textarea[name=message]").val();

        //alert('You picked: ' + name );

        if (name == null || name == "") {
            alert("لا تنسى ان تزودنا باسمك");
            e.preventDefault();
        } else if (message == null || message == "") {
            alert("شاركنا ما تفكر به, اجعل رسالتك بناءة");
            e.preventDefault();
        } else {
            $.ajax({
                type: 'post',
                url: 'sendFeedback.php',
                data: {
                    submit: 'submit',
                    data: $("#feedback").serialize()
                },
                success: function (response) {
                    //alert('Server-side response: ' + response);
                    if (response == "success") {
                        swal({
                            title: 'عمل جيد!',
                            text: "تم الإرسال بنجاح!",
                            type: 'success'
                        })
                    } else {
                        swal({
                            title: 'Error',
                            text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                            type: 'error',
                            timer: 3000
                        })

                    }
                }
            });
            e.preventDefault();
        }

    }); //END dropdown change event


    //####### on page load, retrive votes for each content
    $.each($('.voting_wrapper'), function () {

        //retrive unique id from this voting_wrapper element
        var unique_id = $(this).attr("id");

        //prepare post content
        post_data = {
            'unique_id': unique_id,
            'vote': 'fetch'
        };

        //send our data to "vote_process.php" using jQuery $.post()
        $.post('vote_process.php', post_data, function (response) {

            //retrive votes from server, replace each vote count text
            $('#' + unique_id + ' .up_votes').text(response.vote_up);
            $('#' + unique_id + ' .down_votes').text(response.vote_down);
        }, 'json');
    });

    $(".voting_wrapper .voting_btn").click(function (e) {

        //get class name (down_button / up_button) of clicked element
        var clicked_button = $(this).children().attr('class');

        //get unique ID from voted parent element
        var unique_id = $(this).parent().attr("id");

        if (clicked_button === 'down_button') //user disliked the content
        {
            //prepare post content
            post_data = {
                'unique_id': unique_id,
                'vote': 'down'
            };

            //send our data to "vote_process.php" using jQuery $.post()
            $.post('vote_process.php', post_data, function (data) {

                //replace vote down count text with new values
                $('#' + unique_id + ' .down_votes').text(data);

                //thank user for the dislike
                alert("نأسف لذلك, سنحاول تدارك أخطائنا");

            }).fail(function (err) {

                //alert user about the HTTP server error
                alert(err.statusText);
            });
        } else if (clicked_button === 'up_button') //user liked the content
        {
            //prepare post content
            post_data = {
                'unique_id': unique_id,
                'vote': 'up'
            };

            //send our data to "vote_process.php" using jQuery $.post()
            $.post('vote_process.php', post_data, function (data) {

                //replace vote up count text with new values
                $('#' + unique_id + ' .up_votes').text(data);

                //thank user for liking the content
                swal({
                    title: 'شكراً لك!',
                    text: "لتقدير جهودنا!",
                    type: 'success'
                })
            }).fail(function (err) {

                //alert user about the HTTP server error
                alert(err.statusText);
            });
        }

    });
    //end

}); //END document.ready
