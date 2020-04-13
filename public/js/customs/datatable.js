//custom select entries
$('#usersTable_length').addClass('mdl-textfield mdl-js-textfield mdl-textfield--floating-label');
$('.custom-select').addClass('mdl-textfield__input');
$('.custom-select>option').addClass('mdl-menu__item');

//custom search
$('.dataTables_filter').addClass('mdl-textfield mdl-js-textfield mdl-textfield--floating-label')
$('.dataTables_filter>lable').addClass('mdl-textfield__label');
$('.dataTables_filter>label>input').addClass('mdl-textfield__input');

//custom showing and pagination
$('.dataTables_info')
.parent().parent()
.addClass('mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top')
.css({
    'display' : 'flex',
    'justify-content' : 'space-between'
});