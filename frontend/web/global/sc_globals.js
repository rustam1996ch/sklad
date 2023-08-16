/**
 * Created by nabijon on 2/25/15.
 */

function isNumeric(n)
{
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function isUndefined(variable)
{
    return typeof variable === 'undefined';
}

function isNull(variable)
{
    return variable===null;
}

// console log
function log(message)
{
    return console.log(message);
}

// console log debug
function debug(message)
{
    return console.debug(message);
}

// console log info
function info(message)
{
    //trace();
    return console.info(message);
}

// console log warning
function warn(message)
{
    return console.warn(message);
}

// console log error
function err(message)
{
    //trace('Some error happened:');
    return console.error(message);
}

// modified ajax, shows full error log every time;
function ajaxMy(params)
{
    // show spinner
    var spin = '';
    if(typeof params.spin !== 'undefined') {
        spin = params.spin.html();
        params.spin.html('<i style="font-size: 12px" class="glypicon glyphicon-repeat spin"></i>');
    }

    $.ajax({
        url:  params.url,
        type: params.type,
        data: params.data,
        dataType: params.dataType,
        success: function(data)
        {
            // hide spinner
            if(typeof params.spin !== 'undefined') {
                params.spin.html(spin);
            }

            // call user success callback
            if(typeof params.success !== 'undefined')
                params.success(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            // hide spinner
            if(typeof params.spin !== 'undefined') {
                params.spin.html(spin);
            }

            // log error
            err('Ajax error: ' + XMLHttpRequest.responseText + ', ' + textStatus + ', ' + errorThrown);

            // call error callback of the user
            if(typeof params.error !== 'undefined')
                params.error(XMLHttpRequest, textStatus, errorThrown);
        },
        async: params.async
    });
}

$.ajaxMy = function(params)
{
    return ajaxMy(params);
}

function ajaxmy(params)
{
    return ajaxMy(params);
}

// success alert
function success(message, title)
{
    return alertMy(message, title, 'success');
}

// warning alert
function warning(message, title)
{
    return alertMy(message, title, 'warning');
}

// error alert
function error(message, title)
{
    return alertMy(message, title, 'error');
}

/*
 * Very useful function to detect call stack in ny part of your JS code
 */
function trace()
{
    console.trace();
}

// custom popup alert
// params: message, title, type
// function alertMy(message, title, type)
// {
//     if(typeof title === 'undefined')
//         title = '';

//     if(isNumeric(message))
//     {
//         message = message.toString();
//     }

//     if(typeof swal !== 'undefined')
//     {
//         if(type==='' || isUndefined(type))
//         {
//             if(title!=='')
//                 return  swal(message);
//             else
//                 return  swal(title, message);
//         }
//         else if(type==='success')
//             return swal(title, message, 'success');
//         else if(type==='warning')
//             return swal(title, message, 'warning');
//         else if(type==='error')
//             return swal(title, message, 'error');
//         else
//             return swal(title, message);
//     }
//     else if(typeof bootbox !== 'undefined')
//     {
//         return  bootbox.alert('<label>' + arguments[0] + '</label>');
//     }
//     else
//         return alert(message);
// }

// custom popup prompt
// params: message, defaultValue
function promptMy(arguments)
{
    var result;
    var message = arguments[0];
    var defaultValue = arguments[1];
    var callback = arguments[2];

    if(typeof swal !== 'undefined')
    {
        result = swal({
                title: "",
                text: message,
                type: "input",
                inputValue: defaultValue,
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "..."
            },
            function(inputValue){
                if (inputValue === false) {
                    result = false;
                }
                else if (inputValue === "") {error("You need to write something!");
                    swal.showInputError("You need to write something!");
                    result = false
                }
                else {
                    swal.close();
                    defaultValue = inputValue;
                    result = inputValue;
                }

                callback(result);
            }
        );
    }
    else if(typeof bootbox !== 'undefined') {
        bootbox.prompt({
            title: '<label>' + arguments[0] + '</label>',
            value: defaultValue,
            callback: function (data) {
                result = data;
                callback(data);
            }
        });
    }

    return result;
}

// custom popup confirm
// params: message, callback
function confirmMy(message, callback, buttonTexts)
{
    var result = false;
    if(typeof buttonTexts === 'undefined')
    {
        buttonTexts = [];
        buttonTexts[0] = '';
        buttonTexts[1] = '';
    }

    if(typeof swal !== 'undefined')
    {
        swal({
                title: "",
                text: message,
                type: "warning",
                showCancelButton: true,
                confirmButtonText: buttonTexts[0],
                confirmButtonColor: '#286090',
                cancelButtonText: buttonTexts[1],
                cancelButtonColor: 'red',
                closeOnConfirm: true
            },
            function(confirmed)
            {
                if(confirmed)
                {
                    result = true;
                }
                else
                {
                    result = false;
                    swal.close();
                }

                if(typeof callback !== 'undefined')
                    callback(result);
            }
        );
    }
    else if(typeof bootbox !== 'undefined')
    {
        bootbox.confirm('<label>' + arguments[0] + '</label>', function(result) {
            if(result) {
                callback(result);
            }
        });
    }
    else
    {
        result = confirm(message);

        if(typeof callback !== 'undefined')
            callback(result);
    }

    return result;
}

// custom popup. Arguments: title, html, callback
function dialogMy(title, html, callback, className)
{
    if(typeof swal !== 'undefined')
    {
        swal({
            title: title,
            text: html,
            html: true
        });
    }
    else if(typeof bootbox !== 'undefined')
    {
        bootbox.dialog({
            title: title,
            message: html,
            className: className,
            onEscape: function () {
                if(typeof callback !== 'undefined')
                    callback();
            }
        });
    }
}

// Override basic JS functions like alert, confirm, prompt, etc.
(function() {

    //window.onerror = function(message, url, lineNumber) {
    //    //save error and send to server for example.
    //    err(message + '. Line number: ' + lineNumber);
    //    return true;
    //};

    //alert()
    var proxied = window.alert;
    // window.alert = function() {
    //     var message = arguments[0];
    //     var title = isUndefined(arguments[1]) ? '' : arguments[1];
    //     var type = isUndefined(arguments[2]) ? '' : arguments[2];

    //     return  alertMy(message, title, type);
    // };

    //prompt()
    proxied = window.prompt;
    window.prompt = function() {
        if(typeof arguments[2] === 'undefined')
            return proxied.apply(this, arguments);
        else
            return promptMy(arguments);
    };

    //confirm()
    proxied = window.confirm;
    window.confirm = function() {
        var message = arguments[0];
        var callback = arguments[1];
        var buttonTexts = arguments[2];

        if(typeof arguments[1] === 'undefined')
            return proxied.apply(this, arguments);
        else
            return confirmMy(message, callback, buttonTexts);
    };

    window.modal = function(params) {
        var title = arguments[0];
        var html = arguments[1];
        var callback = arguments[2];
        var className = arguments[3];

        return dialogMy(title, html, callback, className);
    };

    Window.prototype.alert = null;

    Window.prototype.confirm = null;

    Window.prototype.prompt = null;

    Window.prototype.modal = null;

    $.fn.scrollBottom = function(scroll){
        if(typeof scroll === 'number'){
            window.scrollTo(0,$(document).height() - $(window).height() - scroll);
            return $(document).height() - $(window).height() - scroll;
        } else {
            return $(document).height() - $(window).height() - $(window).scrollTop();
        }
    }

    //$.ajax()
    //var oldAjax = $.ajax;
    //
    //$.ajax = function() {
    //
    //    return ajaxMy(arguments);
    //    //return oldAjax.apply($, arguments);
    //
    //}

})();

// get browser url param
function getUrlParamValue(name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);

    if(isNull(results))
        return null;

    return results[1] || 0;
}

/* utf.js - UTF-8 <=> UTF-16 convertion
 *
 * Copyright (C) 1999 Masanao Izumo <iz@onicos.co.jp>
 * Version: 1.0
 * LastModified: Dec 25 1999
 * This library is free.  You can redistribute it and/or modify it.
 */

/*
 * Interfaces:
 * utf8 = utf16to8(utf16);
 * utf16 = utf16to8(utf8);
 */

function utf16to8(str) {
    var out, i, len, c;

    out = "";
    len = str.length;
    for(i = 0; i < len; i++) {
        c = str.charCodeAt(i);
        if ((c >= 0x0001) && (c <= 0x007F)) {
            out += str.charAt(i);
        } else if (c > 0x07FF) {
            out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
            out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));
            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
        } else {
            out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));
            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
        }
    }
    return out;
}

function utf8to16(str) {
    var out, i, len, c;
    var char2, char3;

    out = "";
    len = str.length;
    i = 0;
    while(i < len) {
        c = str.charCodeAt(i++);
        switch(c >> 4)
        {
            case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
            // 0xxxxxxx
            out += str.charAt(i-1);
            break;
            case 12: case 13:
            // 110x xxxx   10xx xxxx
            char2 = str.charCodeAt(i++);
            out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F));
            break;
            case 14:
                // 1110 xxxx  10xx xxxx  10xx xxxx
                char2 = str.charCodeAt(i++);
                char3 = str.charCodeAt(i++);
                out += String.fromCharCode(((c & 0x0F) << 12) |
                ((char2 & 0x3F) << 6) |
                ((char3 & 0x3F) << 0));
                break;
        }
    }

    return out;
}

function getUpdatedUrlParam(key, value)
{
    var uri = document.URL;
    var result = '';
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (uri.match(re)) {
        result = uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        result = uri + separator + key + "=" + value;
    }

    return result;
}

function updateUrlParam(key, value)
{
    var uri = document.URL;
    var result = '';
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (uri.match(re)) {
        result = uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        result = uri + separator + key + "=" + value;
    }

    window.location.href = result;
}

function updateUrlParamAjax(key, value)
{
    var uri = document.URL;
    var result = '';
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (uri.match(re)) {
        result = uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        result = uri + separator + key + "=" + value;
    }

    window.history.pushState('page2', 'Title', result);
}

function removeUrlParams(keys, count)
{
    var result = document.URL;
    var replaced = false;

    for(var i=0; i<count; i++)
    {
        var re = new RegExp("([?&])" + keys[i] + "=.*?(&|$)", "i");
        var separator = result.indexOf('?') !== -1 ? "&" : "?";
        if (result.match(re)) {
            result = result.replace(re, '$1' + '$2');
            replaced = true;
        }
    }

    if(replaced)
    {
        window.location.href = result;
    }
}

function removeUrlParamsAjax(keys, count)
{
    var result = document.URL;
    var replaced = false;

    for(var i=0; i<count; i++)
    {
        var re = new RegExp("([?&])" + keys[i] + "=.*?(&|$)", "i");
        var separator = result.indexOf('?') !== -1 ? "&" : "?";
        if (result.match(re)) {
            result = result.replace(re, '$1' + '$2');
            replaced = true;
        }
    }

    if(replaced)
    {
        window.history.pushState('page2', 'Title', result);
    }
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function setUrlParams(id)
{
    if(id==0)
        updateUrlParam('tabs', 0);
    else
        removeUrlParams(['tabs']);

    removeUrlParams(['success', 'warning', 'error', 'oldId'], 2);
}

function base64_encode(data) {
    //  discuss at: http://phpjs.org/functions/base64_encode/
    // original by: Tyler Akins (http://rumkin.com)
    // improved by: Bayron Guevara
    // improved by: Thunder.m
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Rafał Kukawski (http://kukawski.pl)
    // bugfixed by: Pellentesque Malesuada
    //   example 1: base64_encode('Kevin van Zonneveld');
    //   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
    //   example 2: base64_encode('a');
    //   returns 2: 'YQ=='

    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        enc = '',
        tmp_arr = [];

    if (!data) {
        return data;
    }

    do { // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);
        o3 = data.charCodeAt(i++);

        bits = o1 << 16 | o2 << 8 | o3;

        h1 = bits >> 18 & 0x3f;
        h2 = bits >> 12 & 0x3f;
        h3 = bits >> 6 & 0x3f;
        h4 = bits & 0x3f;

        // use hexets to index into b64, and append result to encoded string
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);

    enc = tmp_arr.join('');

    var r = data.length % 3;

    return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}

(function($){

    var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

    var uTF8Encode = function(string) {
        string = string.replace(/\x0d\x0a/g, "\x0a");
        var output = "";
        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                output += String.fromCharCode(c);
            } else if ((c > 127) && (c < 2048)) {
                output += String.fromCharCode((c >> 6) | 192);
                output += String.fromCharCode((c & 63) | 128);
            } else {
                output += String.fromCharCode((c >> 12) | 224);
                output += String.fromCharCode(((c >> 6) & 63) | 128);
                output += String.fromCharCode((c & 63) | 128);
            }
        }
        return output;
    };

    var uTF8Decode = function(input) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;
        while ( i < input.length ) {
            c = input.charCodeAt(i);
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            } else if ((c > 191) && (c < 224)) {
                c2 = input.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            } else {
                c2 = input.charCodeAt(i+1);
                c3 = input.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }
        }
        return string;
    }

    /**
     * jQuery BASE64 functions
     *
     * 	<code>
     * 		Encodes the given data with base64.
     * 		String $.base64Encode ( String str )
     *		<br />
     * 		Decodes a base64 encoded data.
     * 		String $.base64Decode ( String str )
     * 	</code>
     *
     * Encodes and Decodes the given data in base64.
     * This encoding is designed to make binary data survive transport through transport layers that are not 8-bit clean, such as mail bodies.
     * Base64-encoded data takes about 33% more space than the original data.
     * This javascript code is used to encode / decode data using base64 (this encoding is designed to make binary data survive transport through transport layers that are not 8-bit clean). Script is fully compatible with UTF-8 encoding. You can use base64 encoded data as simple encryption mechanism.
     * If you plan using UTF-8 encoding in your project don't forget to set the page encoding to UTF-8 (Content-Type meta tag).
     * This function orginally get from the WebToolkit and rewrite for using as the jQuery plugin.
     *
     * Example
     * 	Code
     * 		<code>
     * 			$.base64Encode("I'm Persian.");
     * 		</code>
     * 	Result
     * 		<code>
     * 			"SSdtIFBlcnNpYW4u"
     * 		</code>
     * 	Code
     * 		<code>
     * 			$.base64Decode("SSdtIFBlcnNpYW4u");
     * 		</code>
     * 	Result
     * 		<code>
     * 			"I'm Persian."
     * 		</code>
     *
     * @alias Muhammad Hussein Fattahizadeh < muhammad [AT] semnanweb [DOT] com >
     * @link http://www.semnanweb.com/jquery-plugin/base64.html (no longer available?)
     * @link https://gist.github.com/gists/1602210
     * @see http://www.webtoolkit.info/
     * @license http://www.gnu.org/licenses/gpl.html [GNU General Public License]
     * @param {jQuery} {base64Encode:function(input))
	 * @param {jQuery} {base64Decode:function(input))
	 * @return string
     */

    $.extend({
        base64Encode: function(input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;
            input = uTF8Encode(input);
            while (i < input.length) {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }
                output = output + keyString.charAt(enc1) + keyString.charAt(enc2) + keyString.charAt(enc3) + keyString.charAt(enc4);
            }
            return output;
        },
        base64Decode: function(input) {
            var output = "";
            var chr1, chr2, chr3;
            var enc1, enc2, enc3, enc4;
            var i = 0;
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
            while (i < input.length) {
                enc1 = keyString.indexOf(input.charAt(i++));
                enc2 = keyString.indexOf(input.charAt(i++));
                enc3 = keyString.indexOf(input.charAt(i++));
                enc4 = keyString.indexOf(input.charAt(i++));
                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;
                output = output + String.fromCharCode(chr1);
                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }
            }
            output = uTF8Decode(output);
            return output;
        }
    });
})(jQuery);

function fnExcelReport(table, sheetname, filename)
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById(table); // id of table


    for(j = 0 ; j < tab.rows.length ; j++)
    {
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa=txtArea1.document.execCommand("SaveAs",true,filename);
    }
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));


    return (sa);
}

var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(table, name, filename) {
        if (!table.nodeType) table = document.getElementById(table);

        var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

        document.getElementById("dlink").href = uri + base64(format(template, ctx));
        document.getElementById("dlink").download = filename;
        document.getElementById("dlink").click();
    }
})();

function urlParamExists(name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
    return (results && results[1]) || 0;
}

function updateUrlParam(key, value)
{
    var uri = document.URL;
    var result = '';
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (uri.match(re)) {
        result = uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        result = uri + separator + key + "=" + value;
    }

    window.location.href = result;
}

function updateUrlParamAjax(key, value)
{
    var uri = document.URL;
    var result = '';
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (uri.match(re)) {
        result = uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        result = uri + separator + key + "=" + value;
    }

    window.history.pushState('page2', 'Title', result);
}

function removeUrlParamsAjax(keys, count)
{
    var result = document.URL;
    var replaced = false;

    for(var i=0; i<count; i++)
    {
        var re = new RegExp("([?&])" + keys[i] + "=.*?(&|$)", "i");
        var separator = result.indexOf('?') !== -1 ? "&" : "?";
        if (result.match(re)) {
            result = result.replace(re, '$1' + '$2');
            replaced = true;
        }
    }

    if(replaced)
    {
        window.history.pushState('page2', 'Title', result);
    }
}

function removeUrlParams(keys, count)
{
    var result = document.URL;
    var replaced = false;

    for(var i=0; i<count; i++)
    {
        var re = new RegExp("([?&])" + keys[i] + "=.*?(&|$)", "i");
        var separator = result.indexOf('?') !== -1 ? "&" : "?";
        if (result.match(re)) {
            result = result.replace(re, '$1' + '$2');
            replaced = true;
        }
    }

    if(replaced)
    {
        window.location.href = result;
    }
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function setUrlParams(id)
{
    if(id==0)
        updateUrlParam('tabs', 0);
    else
        removeUrlParams(['tabs']);

    removeUrlParams(['success', 'warning', 'error', 'oldId'], 2);
}

// show print dialog in apopup
function printHtml(html)
{
    document.body.insertAdjacentHTML('afterbegin', '<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>');

    window.frames["print_frame"].document.body.innerHTML = html;
    window.frames["print_frame"].window.focus();

    setTimeout(function(){
        window.frames["print_frame"].window.print();
    }, 500);
}

// show print dialog in apopup
function showPrintDialog(html)
{
    printHtml(html);
}

function isValidEmail(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function areValidEmails(emails)
{
    if(emails!==null)
    {
        var i=0;
        for(i=0; i<emails.length; i++)
        {
            if(!isValidEmail((emails[i])))
                return false;
        }

        return true;
    }
}

function fadeBackground(element, color, time)
{
    var originalBgcolor = element.css("background-color");
    element.css("background-color",color).fadeIn(500).fadeOut(100).css("background-color",originalBgcolor).fadeIn(100);
}

function bootstrapUpdateModal($modal)
{
    $modal.removeData('bs.modal');
}

function setSelection($select, value)
{
    $('#foldersList option:eq(data)').prop('selected', 'selected');
}

function isLocalhost()
{
    if (window.location.host == "localhost")
        return true;
    else
        return false;
}

// exceute callback function on selected htmln table rows
function callbackSelectedTableRows(tableId, rowIds, callback)
{
    for(var i=0; i<rowIds.length; i++)
    {
        $(tableId + " tr").eq(i).toggleClass('selected');
    }

    $(tableId + " tr.selected").each(function(){
        callback(this);
    });
}

function getNeighbourCellsTable($td)
{
    //var $td = $('table tr:eq(2) td:eq(2)'); //current td = 5

    var index = $td.index(), $tr =$td.parent();
    var $nbrs = $td.prev().add($td.next()).add($tr.prev().find('td').eq(index)).add($tr.next().find('td').eq(index));

    //$nbrs.css('color', 'red')
    return $nbrs.get();
}

function  getRowIndexOfCellTable(td)
{
    //var $td = $('table tr:eq(2) td:eq(2)'); //current td = 5

    return td.closest('tr') // Get the closest tr parent element
        .prevAll() // Find all sibling elements in front of it
        .length; // Get their count
}

function getRowsOfCellsTable($tdArray)
{
    rows = [];

    for(var i=0; i<$tdArray.length; i++)
    {
        rows[i] = getRowIndexTable($tdArray[i]);
    }

    return rows;
}

function getUniqueValuesArray(array)
{
    for (var i=0, l=this.length; i<l; i++)
        if (array.indexOf(this[i]) === -1)
            a.push(this[i]);

    return array;
}

function apply_gridview_filter() {

    $('.grid-view').yiiGridView('applyFilter');

}

function applyGridviewFilter() {

    $('.grid-view').yiiGridView('applyFilter');

}

function updateGridview(gridviewId)
{
    jQuery.fn.yiigridview.update(gridviewId);
}

function n_format($number, $decimals)
{
    $number = Number($number);
    $number = n_format1($number, $decimals);

    var n = Number($number),
        c = $decimals,//isNaN(c = Math.abs(c)) ? 2 : c,
        d = '.',//d == undefined ? "." : d,
        t = ' ',//t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    result = s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");

    return String(result);
}

function n_format1($number, $decimals)
{
    if(typeof $decimals === 'undefined')
        $decimals = 0;

    return Number($number).toFixed($decimals);
}

function removeSpace(str)
{
    if (str!==undefined && str!=='') {
        return str.replace(/\s/g, '');
    } else {
        return 0;
    }
}

function dateMy()
{
    var date = new Date();
    var day = date.getUTCDay();
    var month = date.getUTCMonth();
    var year = date.getUTCFullYear();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    //var seconds = date.getSeconds();

    return date.toLocaleString();//String(day + '.' + month + '.' + year + ' ' + hours + ':' + minutes/* + ':' + seconds*/);
}

//  @TODO: fix GMT issue
function dateSql(date)
{
    return date.getUTCFullYear() + '-' +
    ('00' + (date.getUTCMonth() + 1)).slice(-2) + '-' +
    ('00' + date.getUTCDate()).slice(-2) + ' ' +
    ('00' + date.getUTCHours()).slice(-2) + ':' +
    ('00' + date.getUTCMinutes()).slice(-2) + ':' +
    ('00' + date.getUTCSeconds()).slice(-2);
}

/*
 * Find model ($modelName) on given $condition (or modelId) and set $fields (key=>value).
 * If model not found and $createIfNotFound create a new one.
 * Returns created/edited model as a result.
 */
function syncInline(modelName, condition, fields, createIfNotFound, callback) {trace();

    var canCreate;

    if(typeof createIfNotFound === 'undefined' || createIfNotFound == null)
        canCreate = 1;
    else
        canCreate = createIfNotFound;

    ajaxmy
    ({
        url: 'index.php?r=' + modelName.toLowerCase() + '/sync-inline',
        type: 'post',
        data: {modelName: '\\app\\models\\' + modelName, condition: condition, fields: fields, createIfNotFound: canCreate},
        success: function (data) {
            if (typeof callback !== 'undefined') {
                callback(data);
            }
        }
        //async: false
    });

}

function str_pad(input, pad_length, pad_string, pad_type) {
    //  discuss at: http://phpjs.org/functions/str_pad/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Michael White (http://getsprink.com)
    //    input by: Marco van Oort
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //   example 1: str_pad('Kevin van Zonneveld', 30, '-=', 'STR_PAD_LEFT');
    //   returns 1: '-=-=-=-=-=-Kevin van Zonneveld'
    //   example 2: str_pad('Kevin van Zonneveld', 30, '-', 'STR_PAD_BOTH');
    //   returns 2: '------Kevin van Zonneveld-----'

    var half = '',
        pad_to_go;

    var str_pad_repeater = function(s, len) {
        var collect = '',
            i;

        while (collect.length < len) {
            collect += s;
        }
        collect = collect.substr(0, len);

        return collect;
    };

    input += '';
    pad_string = pad_string !== undefined ? pad_string : ' ';

    if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
        pad_type = 'STR_PAD_RIGHT';
    }
    if ((pad_to_go = pad_length - input.length) > 0) {
        if (pad_type === 'STR_PAD_LEFT') {
            input = str_pad_repeater(pad_string, pad_to_go) + input;
        } else if (pad_type === 'STR_PAD_RIGHT') {
            input = input + str_pad_repeater(pad_string, pad_to_go);
        } else if (pad_type === 'STR_PAD_BOTH') {
            half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
            input = half + input + half;
            input = input.substr(0, pad_length);
        }
    }

    return input;
}

function showSpinner($element)
{
    $element.hide();
    $element.after('<img class="spinner" src="../../vendor_server/sobercoding/images/loading.gif">');
}

function redrawDom()
{
    //$(window).trigger('resize');
    window.getComputedStyle();
}

function setModelFieldValue(modelUrlName, modelId, field, value)
{
    var result = false;

    ajaxMy
    ({
        url: getUpdatedUrlParam('r', modelUrlName + '/set-model-field-value'),
        type: 'GET',
        dataType: 'html',
        data: 'modelId=' + modelId + '&field=' + field + '&value=' + value,
        success: function(data) {
            result = data;
        },
        async: false
    });

    return result;
}

function getModelFieldValue(modelUrlName, modelId, field)
{
    var result = false;

    ajaxMy
    ({
        url: getUpdatedUrlParam('r', modelUrlName + '/get-this-model-field-value'),
        type: 'GET',
        dataType: 'html',
        data: 'modelId=' + modelId + '&field=' + field,
        success: function(data) {
            result = data;
        },
        async: false
    });

    return result;
}

function getModelMethod(modelName, modelId, method, args)
{
    var result = false;
    args = typeof args === 'undefined' ? null : args;

    ajaxMy
    ({
        url: getUpdatedUrlParam('r', 'site/get-model-method'),
        type: 'GET',
        dataType: 'html',
        data: 'modelName=' + modelName + '&modelId=' + modelId + '&method=' + method + '&args=' + args,
        success: function(data) {
            result = data;
        },
        async: false
    });

    return result;
}

function openSelect(jsElem)
{
    var element = jsElem;//$("select")[0];
    var worked = false;

    if (document.createEvent) {
        var e = document.createEvent("MouseEvents");
        e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        worked = element.dispatchEvent(e);
    } else if (element.fireEvent) {
        worked = element.fireEvent("onmousedown");
    }
    if (!worked) {
        info("It didn't worked in your browser.");
    }
}


function number_format(number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase
    //  discuss at: http://locutus.io/php/number_format/
    // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // improved by: Kevin van Zonneveld (http://kvz.io)
    // improved by: davook
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Theriault (https://github.com/Theriault)
    // improved by: Kevin van Zonneveld (http://kvz.io)
    // bugfixed by: Michael White (http://getsprink.com)
    // bugfixed by: Benjamin Lupton
    // bugfixed by: Allan Jensen (http://www.winternet.no)
    // bugfixed by: Howard Yeend
    // bugfixed by: Diogo Resende
    // bugfixed by: Rival
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    //  revised by: Luke Smith (http://lucassmith.name)
    //    input by: Kheang Hok Chin (http://www.distantia.ca/)
    //    input by: Jay Klehr
    //    input by: Amir Habibi (http://www.residence-mixte.com/)
    //    input by: Amirouche
    //   example 1: number_format(1234.56)
    //   returns 1: '1,235'
    //   example 2: number_format(1234.56, 2, ',', ' ')
    //   returns 2: '1 234,56'
    //   example 3: number_format(1234.5678, 2, '.', '')
    //   returns 3: '1234.57'
    //   example 4: number_format(67, 2, ',', '.')
    //   returns 4: '67,00'
    //   example 5: number_format(1000)
    //   returns 5: '1,000'
    //   example 6: number_format(67.311, 2)
    //   returns 6: '67.31'
    //   example 7: number_format(1000.55, 1)
    //   returns 7: '1,000.6'
    //   example 8: number_format(67000, 5, ',', '.')
    //   returns 8: '67.000,00000'
    //   example 9: number_format(0.9, 0)
    //   returns 9: '1'
    //  example 10: number_format('1.20', 2)
    //  returns 10: '1.20'
    //  example 11: number_format('1.20', 4)
    //  returns 11: '1.2000'
    //  example 12: number_format('1.2000', 3)
    //  returns 12: '1.200'
    //  example 13: number_format('1 000,50', 2, '.', ' ')
    //  returns 13: '100 050.00'
    //  example 14: number_format(1e-8, 8, '.', '')
    //  returns 14: '0.00000001'

    number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
    var n = !isFinite(+number) ? 0 : +number
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
    var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
    var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
    var s = ''

    var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec)
        return '' + (Math.round(n * k) / k)
            .toFixed(prec)
    }

    // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
    }

    return s.join(dec)
}
