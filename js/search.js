/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validateForm() {
    var str = document.forms["searchForm"]['keyword'].value;
    if (/\S/.test(str)) {
        return true;
    }
    return false;
}

function submitForm() {
    $('#searchForm').submit();
}
