var credentials = {};

$(document).ready(function() {
    $('.datepicker').datepicker();

    $(document).on('click blur', 'td', function() {
        var conattr = $(this).attr('contenteditable');
        if (typeof conattr !== typeof undefined && conattr !== false) {
            var sum = 0;
            var p = $(this).parent();

            $(p).find('.edit-item').each(function() {
                sum += Number($(this).html());
            });
            
            $(p).find('.total_hrs').html(sum);
        }
    })

    $('#reset_btn').click(function() {
        document.location.href = document.location.href;
    });

    $('#approve_modal_btn').click(function() {
        $('#password').val('');
        $('#password').focus();
        $('#password_modal').modal();
    });

    $('#approve_btn').click(function() {
        show_sign();
    });

    $('#report_btn').click(function() {
        if ($('.datepicker').val() == '') {
            alert('Please enter PAYROLL PERIOD ENDING');
            return;
        }

        if ($('.sign').html() == '') {
            alert('Please approve before sending');
            return;
        }

        var tbl_data = '';
        $('tbody tr').each(function() {
            tbl_data += '<tr>';
            $(this).find('td').each(function() {
                if ($(this).attr('class') == 'need_hide') return true;
                tbl_data += '<td>' + $(this).html() + '</td>';
            }) 
            tbl_data += '</tr>';
        });

        $.ajax({
            url: $('#base_url').val() + 'index.php/welcome/sendEmail',
            method: 'POST',
            data: {
                date: $('.datepicker').val(),
                img: $('.sign img').attr('src'),
                tbl_data: tbl_data
            },
            success: function(ret) {
                console.log(ret);
                alert('Success');
                return false;
            }
        });
    });

    $(document).on('click', '.remove_tr', function() {
        if (confirm('Are you sure?')) {
            $(this).closest('tr').remove();
        }
    });

    $('.modal-form').submit(function(e) {
        e.preventDefault();
        show_sign();
    });

    initialTbl();

    credentials = JSON.parse($('#credential').val());
});

function initialTbl() {
    var s = localStorage.getItem('kirk_save');
    var html = '';
    if (s) {
        var saved = JSON.parse(s);
        for (var i in saved) {
            html += '<tr>';
            html += '   <td contenteditable>' + saved[i][0] + '</td>';
            html += '   <td contenteditable>' + saved[i][1] + '</td>';
            html += '   <td contenteditable>' + saved[i][2] + '</td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="total_hrs"></td>';
            html += '   <td contenteditable></td>';
            html += '   <td class="need_hide"><a href="javascript:void(0);" class="remove_tr"><i class="glyphicon glyphicon-trash"></i></a></td>';
            html += '</tr>';
        }
    } else {
        for (var i = 0; i < 5; i ++) {
            html += '<tr>';
            html += '   <td contenteditable></td>';
            html += '   <td contenteditable></td>';
            html += '   <td contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="edit-item" contenteditable></td>';
            html += '   <td class="total_hrs"></td>';
            html += '   <td contenteditable></td>';
            html += '   <td class="need_hide"><a href="javascript:void(0);" class="remove_tr"><i class="glyphicon glyphicon-trash"></i></a></td>';
            html += '</tr>';
        }
    }

    $('tbody').html(html);
}

function show_sign() {
    var passwd = $('#password').val();
    if ($('#password').val() == '') {
        alert('Enter your password.'); 
        return;
    }

    if (credentials[passwd] !== undefined) {
        var file_link = $('#base_url').val() + 'assets/img/' + credentials[passwd] + '.jpg';
        // var file_link = 'assets/img/' + credentials[passwd] + '.jpg';
        $('.sign').html('<img src="' + file_link + '">');
    } else {
        $('.sign').html('');
    }

    $('#password_modal').modal('hide');
}

function add_row() {
    var html = "";
    html += '<tr>';
    html += '   <td contenteditable></td>';
    html += '   <td contenteditable></td>';
    html += '   <td contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="edit-item" contenteditable></td>';
    html += '   <td class="total_hrs"></td>';
    html += '   <td contenteditable></td>';
    html += '   <td class="need_hide"><a href="javascript:void(0);" class="remove_tr"><i class="glyphicon glyphicon-trash"></i></a></td>';
    html += '</tr>';

    $('table tbody').append(html);
}

function save_rows() {
    var tr = [];
    $('tbody tr').each(function() {
        var sub = [];
        var flag = true;
        $(this).find('td').each(function(i, el) {
            if (i === 0) {
                if ($(this).html() == '') {
                    flag = false;
                    return true;
                } 
                sub.push($(this).html());
            } else if (i === 1) {
                if (!flag) return true;
                sub.push($(this).html());
            } else if (i === 2) {
                if (!flag) return true;
                sub.push($(this).html());
            }
        });

        if (sub.length) tr.push(sub);
    });

    console.log(tr);
    localStorage.setItem("kirk_save", JSON.stringify(tr));
}